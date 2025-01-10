<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmailVerification;
use App\Mail\opt_sender;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\UserSubscription;
use Exception;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Subscription as SubscriptionDetails;
use Stripe\Customer;
use Stripe\Stripe;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Constructor for the RegisterController.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Handle API registration.
     */
    public function apiRegister(Request $request)
    {
        try {
            // Validate request data
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users',
                'role' => 'required|string|in:user_interface,consultant_interface',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
            }

            Stripe::setApiKey(config('services.stripe.secret'));

            // Start a transaction
            DB::beginTransaction();

            // Create a new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => Hash::make($request->password),
            ]);

            // Send OTP
            try {
                $this->sendOtp($user);
            } catch (Exception $e) {
                // Rollback on OTP failure
                DB::rollBack();
                Log::error('Failed to send OTP: ' . $e->getMessage(), ['user_id' => $user->id]);
                return response()->json(['success' => false, 'message' => 'Registration failed. Unable to send OTP.'], 500);
            }

            // Create a new Stripe customer if none exists
            $customer = Customer::create([
                'name' => $user->name,
                'email' => $user->email,
            ]);

            // Create a user subscription record
            $user_subscription = UserSubscription::create([
                'user_id' => $user->id,
                'subscription_plan_id' => SubscriptionDetails::where('name', 'Free Plan')->first()->id,
                'stripe_customer_id' => $customer->id,
            ]);

            // Commit the transaction
            DB::commit();

            // Include updated subscription and customer data in the response
            $user->customer = $customer;
            $user->subscription = $user_subscription;

            // Return a successful response
            return response()->json(['success' => true, 'message' => 'User registered successfully', 'data' => $user], 201);
        } catch (Exception $e) {
            // Rollback any ongoing transaction
            DB::rollBack();

            // Catch any unexpected errors and log them
            Log::error('Error during user registration: ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => "An unexpected error occurred. Please try again later."], 500);
        }
    }

    /**
     * Send OTP to the user's email.
     */
    public function sendOtp($user)
    {
        try {
            // Start a transaction for OTP creation and sending
            DB::transaction(function () use ($user) {
                // Generate 6-digit OTP
                $otp = rand(100000, 999999);

                // Delete and recreate OTP data
                EmailVerification::where('email', $user->email)->delete();

                // Store OTP in the database
                EmailVerification::create([
                    'email' => $user->email,
                    'otp' => $otp,
                ]);

                // Attempt to send OTP via email
                Mail::to($user->email)->send(new opt_sender($user, $otp));
            });
        } catch (Exception $e) {
            // Catch any unexpected errors and log them
            Log::error('Error generating OTP for ' . $user->email . ': ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => "An unexpected error occurred. Please try again later."], 500);
        }
    }

    /**
     * Resend OTP to the user's email if the previous OTP was generated more than 30 seconds ago.
     */
    public function resendOtp(Request $request)
    {
        try {
            // Validate the incoming request
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
            }

            // Find the user by their ID
            $user = User::where('id', $request->id)->first();

            // Check if the user exists
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }

            // Get the latest OTP data for the user's email
            $otpData = EmailVerification::where('email', $user->email)->first();

            if ($otpData) {
                // Get the current time and the time when the OTP was created
                $currentTime = now();
                $otpCreationTime = $otpData->created_at;

                // Check if less than 30 seconds have passed since the OTP was created
                if ($otpCreationTime->diffInSeconds($currentTime) < 30) {
                    $remainingTime = 30 - $currentTime->diffInSeconds($otpCreationTime);
                    return response()->json(['success' => false, 'message' => "Please wait $remainingTime seconds before requesting a new OTP"], 401);
                }
            }

            // Send a new OTP to the user's email
            try {
                $this->sendOtp($user);
            } catch (Exception $e) {
                Log::error('Failed to resend OTP: ' . $e->getMessage(), ['user_id' => $user->id]);
                return response()->json(['success' => false, 'message' => 'Resend failed. Unable to resend OTP.'], 500);
            }

            // Return success response after sending the OTP
            return response()->json(['success' => true, 'message' => 'OTP sent to your email address'], 200);
        } catch (Exception $e) {
            // Catch any unexpected errors and log them
            Log::error('Error in resendOtp: ' . $e->getMessage(), [
                'user_id' => $request->id ?? null,
            ]);
            return response()->json(['message' => "An unexpected error occurred. Please try again later."], 500);
        }
    }

    /**
     * Verify OTP for the user and mark the user as verified.
     */
    public function verifiedOtp(Request $request)
    {
        try {
            // Validate the incoming request
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
                'otp' => 'required|string|max:6',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
            }

            // Find the user by their ID
            $user = User::where('id', $request->id)->first();

            // Check if the user exists
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }

            // Find OTP data based on the provided OTP and the user's email
            $otpData = EmailVerification::where('otp', $request->otp)
                ->where('email', $user->email)
                ->first();

            // If no OTP data exists, the provided OTP is invalid
            if (!$otpData) {
                return response()->json(['success' => false, 'message' => 'Invalid OTP.'], 401);
            }

            // Get the time when the OTP was created
            $time = $otpData->created_at;

            // Check if the OTP has expired (15 minutes limit)
            if (now()->gt($time->addMinutes(15))) {
                return response()->json(['success' => false, 'message' => 'Your OTP has expired'], 401);
            }

            Stripe::setApiKey(config('services.stripe.secret'));

            // Retrieve or create a user subscription record
            $user_subscription = UserSubscription::where('user_id', $user->id)->first();

            $customer = Customer::retrieve($user_subscription->stripe_customer_id);

            // Start a database transaction
            DB::transaction(function () use ($user, $otpData) {
                // Mark the user as verified
                $user->update(['is_verified' => 1, 'email_verified_at' => now()]);

                // Delete the OTP record
                $otpData->delete();
            });

            // Include updated subscription and customer data in the response
            $user->customer = $customer;
            $user->subscription = $user_subscription;

            // Return success response with the user data
            return response()->json(['success' => true, 'message' => 'User verified successfully', 'data' => $user], 200);
        } catch (Exception $e) {
            // Catch any unexpected errors and log them
            Log::error('Error in otp verification: ' . $e->getMessage(), [
                'user_id' => $request->id ?? null,
            ]);
            return response()->json(['message' => "An unexpected error occurred. Please try again later."], 500);
        }
    }

    /**
     * Handle the registration process.
     */
    public function register(Request $request)
    {
        // Validate the request data using the custom validator
        $this->validator($request->all())->validate();

        // Create the user in the database
        $user = $this->create($request->all());

        // Store the user ID in the session for later use
        session(['User_id' => $user->id]);

        // Redirect the user to the homepage (or a different route)
        return redirect()->route("home");
    }

    /**
     * Validate the registration data.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user in the database.
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['user_role'],
            'password' => Hash::make($data['password']),
        ]);
    }

    // Don't know why is it made
    public function verify_otp(Request $request)
    {
        // Find the user by their ID
        $user = User::where('id', $request->id)->first();

        // Check if the user exists
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        $this->sendOtp($user);
        Stripe::setApiKey(config('services.stripe.secret'));

        // Retrieve or create a user subscription record
        $user_subscription = UserSubscription::where('user_id', $user->id)->first();

        $customer = Customer::retrieve($user_subscription->stripe_customer_id);

        // Include updated subscription and customer data in the response
        $user->customer = $customer;
        $user->subscription = $user_subscription;

        return response()->json(['success' => true, 'message' => 'Otp Send To your Account', 'data' => $user], 200);
    }
}
