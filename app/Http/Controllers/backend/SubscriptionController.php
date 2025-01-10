<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Subscription;
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\Subscription as SubscriptionDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Stripe\PaymentMethod;
use Tymon\JWTAuth\Facades\JWTAuth;

class SubscriptionController extends Controller
{
    // Define allowed subscription types as constants
    const SUBSCRIPTION_TYPES = ['free', 'pro', 'unlimited'];

    /**
     * Handle subscription requests from users.
     */
    public function subscribe(Request $request)
    {
        try {
            // Authenticate the user using JWTAuth
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'payment_method' => 'string|nullable',
                'subscription_type' => 'required|in:' . implode(',', self::SUBSCRIPTION_TYPES),
            ], [
                'subscription_type.required' => 'The subscription type is required.',
                'subscription_type.in' => 'Invalid subscription type. Allowed values are: ' . implode(', ', self::SUBSCRIPTION_TYPES) . '.',
            ]);

            // Return validation errors if any
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
            }

            // Handle subscriptions based on the type
            if ($request->subscription_type === 'free') {
                return $this->handleFreeSubscription($user);
            }

            if ($request->subscription_type === 'pro') {
                if (!$request->payment_method) {
                    return response()->json(['success' => false, 'errors' => ['payment_method' => 'Payment method is required']], 400);
                }
                return $this->handleProSubscription($user, $request->payment_method);
            }

            if ($request->subscription_type === 'unlimited') {
                if (!$request->payment_method) {
                    return response()->json(['success' => false, 'errors' => ['payment_method' => 'Payment method is required']], 400);
                }
                return $this->handleUnlimitedSubscription($user, $request->payment_method);
            }

            // Return for unsupported subscription types
            return response()->json(['success' => false, 'message' => 'Subscription type not yet implemented.'], 501);
        } catch (Exception $e) {
            // Log errors and return a generic error message
            Log::error("Subscription Error for User ID {$request->id}: {$e->getMessage()}");
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Handle Free subscription logic.
     */
    private function handleFreeSubscription($user)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        // Retrieve or create a user subscription record
        $user_subscription = UserSubscription::firstOrCreate(['user_id' => $user->id]);

        // Retrieve the Free Plan subscription details
        $subscription_plan = SubscriptionDetails::where('name', 'Free Plan')->first();
        if (!$subscription_plan) {
            return response()->json(['success' => false, 'message' => 'Free Plan not configured.'], 501);
        }

        DB::beginTransaction();
        try {
            // Cancel existing Stripe subscription if any
            if ($user_subscription->stripe_subscription_id) {
                $stripe_subscription = Subscription::retrieve($user_subscription->stripe_subscription_id);

                if ($stripe_subscription && $stripe_subscription->status !== 'canceled') {
                    $stripe_subscription->cancel(['at_period_end' => false]);
                }
                $user_subscription->stripe_subscription_id = null;
            }

            // Detach any default payment method if a Stripe customer exists
            if ($user_subscription->stripe_customer_id) {
                $customer = Customer::retrieve($user_subscription->stripe_customer_id);

                if (!empty($customer->invoice_settings->default_payment_method)) {
                    // Retrieve the payment method instance
                    $payment_method_id = $customer->invoice_settings->default_payment_method;
                    $payment_method = PaymentMethod::retrieve($payment_method_id);

                    // Detach the payment method    
                    $payment_method->detach();
                }
            } else {
                // Create a new Stripe customer if none exists
                $customer = Customer::create([
                    'name' => $user->name,
                    'email' => $user->email,
                ]);
                $user_subscription->stripe_customer_id = $customer->id;
            }

            // Update subscription details in the database
            $user_subscription->subscription_plan_id = $subscription_plan->id;
            $user_subscription->start_date = null;
            $user_subscription->end_date = null;
            $user_subscription->save();

            DB::commit();

            // Include updated subscription and customer data in the response
            $user->customer = $customer;
            $user->subscription = $user_subscription;
            return response()->json(['success' => true, 'message' => 'Subscription updated to Free Plan.', 'user' => $user], 200);
        } catch (Exception $e) {
            // Rollback transaction and log the error
            DB::rollBack();
            Log::error("Failed to update subscription: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update subscription. Please try again.'], 500);
        }
    }

    /**
     * Handle Pro subscription logic.
     */
    private function handleProSubscription($user, $paymentMethodId)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        // Retrieve or create a user subscription record
        $user_subscription = UserSubscription::firstOrCreate(['user_id' => $user->id]);

        // Retrieve the Free Plan subscription details
        $subscription_plan = SubscriptionDetails::where('name', 'Pro Plan')->first();
        if (!$subscription_plan) {
            return response()->json(['success' => false, 'message' => 'Pro Plan not configured.'], 501);
        }

        DB::beginTransaction();
        try {
            // Retrieve if a Stripe customer exists
            if ($user_subscription->stripe_customer_id) {
                $customer = Customer::retrieve($user_subscription->stripe_customer_id);
            } else {
                // Create a new Stripe customer if none exists
                $customer = Customer::create([
                    'name' => $user->name,
                    'email' => $user->email,
                ]);
                $user_subscription->stripe_customer_id = $customer->id;
            }

            if ($paymentMethodId) {
                $paymentMethod = PaymentMethod::retrieve($paymentMethodId);
                $paymentMethod->attach(['customer' => $customer->id]);

                $customer = Customer::update($customer->id, [
                    'invoice_settings' => ['default_payment_method' => $paymentMethodId],
                ]);
            }

            // Cancel existing Stripe subscription if any
            if ($user_subscription->stripe_subscription_id) {
                $existing_subscription = Subscription::retrieve($user_subscription->stripe_subscription_id);

                if ($existing_subscription && $existing_subscription->status !== 'canceled') {
                    $existing_subscription->cancel(['at_period_end' => false]);
                }
                $user_subscription->stripe_subscription_id = null;
            }

            $stripe_subscription = Subscription::create([
                'customer' => $customer->id,
                'items' => [
                    ['price' => $subscription_plan->stripe_price_id],
                ],
                'expand' => ['latest_invoice.payment_intent'],
            ]);

            // Update subscription details in the database
            $user_subscription->stripe_subscription_id = $stripe_subscription->id;
            $user_subscription->subscription_plan_id = $subscription_plan->id;
            $user_subscription->start_date = Carbon::createFromTimestamp($stripe_subscription->current_period_start);
            $user_subscription->end_date = Carbon::createFromTimestamp($stripe_subscription->current_period_end);
            $user_subscription->save();

            DB::commit();

            // Include updated subscription and customer data in the response
            $user->customer = $customer;
            $user->subscription = $user_subscription;
            return response()->json(['success' => true, 'message' => 'Subscription updated to Pro Plan.', 'user' => $user], 200);
        } catch (Exception $e) {
            // Rollback transaction and log the error
            DB::rollBack();
            Log::error("Failed to update subscription: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update subscription. Please try again.'], 500);
        }
    }

    /**
     * Handle Unlimited subscription logic.
     */
    private function handleUnlimitedSubscription($user, $paymentMethodId)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        // Retrieve or create a user subscription record
        $user_subscription = UserSubscription::firstOrCreate(['user_id' => $user->id]);

        // Retrieve the Free Plan subscription details
        $subscription_plan = SubscriptionDetails::where('name', 'Unlimited Plan')->first();
        if (!$subscription_plan) {
            return response()->json(['success' => false, 'message' => 'Unlimited Plan not configured.'], 501);
        }

        DB::beginTransaction();
        try {
            // Retrieve if a Stripe customer exists
            if ($user_subscription->stripe_customer_id) {
                $customer = Customer::retrieve($user_subscription->stripe_customer_id);
            } else {
                // Create a new Stripe customer if none exists
                $customer = Customer::create([
                    'name' => $user->name,
                    'email' => $user->email,
                ]);
                $user_subscription->stripe_customer_id = $customer->id;
            }

            if ($paymentMethodId) {
                $paymentMethod = PaymentMethod::retrieve($paymentMethodId);
                $paymentMethod->attach(['customer' => $customer->id]);

                $customer = Customer::update($customer->id, [
                    'invoice_settings' => ['default_payment_method' => $paymentMethodId],
                ]);
            }

            // Cancel existing Stripe subscription if any
            if ($user_subscription->stripe_subscription_id) {
                $existing_subscription = Subscription::retrieve($user_subscription->stripe_subscription_id);

                if ($existing_subscription && $existing_subscription->status !== 'canceled') {
                    $existing_subscription->cancel(['at_period_end' => false]);
                }
                $user_subscription->stripe_subscription_id = null;
            }

            $stripe_subscription = Subscription::create([
                'customer' => $customer->id,
                'items' => [
                    ['price' => $subscription_plan->stripe_price_id],
                ],
                'expand' => ['latest_invoice.payment_intent'],
            ]);

            // Update subscription details in the database
            $user_subscription->stripe_subscription_id = $stripe_subscription->id;
            $user_subscription->subscription_plan_id = $subscription_plan->id;
            $user_subscription->start_date = Carbon::createFromTimestamp($stripe_subscription->current_period_start);
            $user_subscription->end_date = Carbon::createFromTimestamp($stripe_subscription->current_period_end);
            $user_subscription->save();

            DB::commit();

            // Include updated subscription and customer data in the response
            $user->customer = $customer;
            $user->subscription = $user_subscription;
            return response()->json(['success' => true, 'message' => 'Subscription updated to Unlimited Plan.', 'user' => $user], 200);
        } catch (Exception $e) {
            // Rollback transaction and log the error
            DB::rollBack();
            Log::error("Failed to update subscription: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update subscription. Please try again.'], 500);
        }
    }
}
