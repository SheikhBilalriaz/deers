<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserSubscription;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Log;
use Stripe\Customer;
use Stripe\Stripe;

/*
|----------------------------------------------------------------------
| Login Controller
|----------------------------------------------------------------------
|
| This controller handles authenticating users for the application and
| redirecting them to your home screen. The controller uses a trait
| to conveniently provide its functionality to your applications.
|
*/

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function validateLogin(Request $request)
    {
        return Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Invalid credentials.']);
        }

        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->intended($this->redirectTo);
        }

        Auth::logout();
        return redirect()->route('login')
            ->withErrors(['email' => 'Unauthorized to access this dashboard.']);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }

    /**
     * Handle login requests for the mobile application API.
     */
    public function appLogin(Request $request)
    {
        try {
            // Start a transaction
            DB::beginTransaction();

            // Validate the login request
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
            }

            // Attempt to authenticate the user
            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return response()->json(['success' => false, 'message' => 'Invalid credentials.'], 401);
            }

            $user = Auth::user();

            // Check if the user's email is verified
            if (!$user->is_verified) {
                // Logout the user
                Auth::logout();
                return response()->json(['success' => false, 'message' => 'User Not Verified.'], 401);
            }

            // Generate a JWT token for the authenticated user
            $token = JWTAuth::fromUser($user);

            Stripe::setApiKey(config('services.stripe.secret'));

            // Retrieve or create a user subscription record
            $user_subscription = UserSubscription::where('user_id', $user->id)->first();

            $customer = Customer::retrieve($user_subscription->stripe_customer_id);

            // Commit the transaction
            DB::commit();

            // Include updated subscription and customer data in the response
            $user->customer = $customer;
            $user->subscription = $user_subscription;

            return response()->json([
                'success' => true,
                'token' => $token,
                'message' => 'User successfully logged in',
                'data' => $user,
            ]);
        } catch (Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            // Log the error
            Log::error('Error during app login: ' . $e->getMessage(), [
                'email' => $request->email
            ]);

            return response()->json(['success' => false, 'message' => 'An unexpected error occurred. Please try again later.'], 500);
        }
    }
}
