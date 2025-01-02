<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->route('login')
                            ->withErrors($validator)
                            ->withInput();
        }

        // Attempt to log the user in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Retrieve the authenticated user
            $user = Auth::user();

            // Check if the user has the 'admin' role
            if ($user->role === 'admin') {
                // Authentication passed and user is an admin
                return redirect()->intended('/');
            } else {
                // Log the user out if they are not an admin
                Auth::logout();
                return redirect()->route('login')
                                ->withErrors(['email' => 'You are not authorized to access this dashboard.']);
            }
        }

        // Authentication failed
        return redirect()->route('login')
                        ->withErrors(['email' => 'These credentials do not match our records.']);
    }


    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login');
    }

    public function appLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            if($user->is_verified == 1){

                $user = Auth::user();
                $token = JWTAuth::fromUser($user);
                $user_id = $user->id;
                $user_name = $user->name;
                $user_role = $user->role;

                return response()->json([
                    'token' => $token,
                    'message' => 'Login successful',
                    'user_id' => $user_id,
                    'user_name' => $user_name,
                    'user_role' => $user_role,
                ]);
            }
            return response()->json(['success' => false, 'message' => 'User Not Verified.'], 401);
        } else {
            return response()->json(['error' => 'Email or Password are incorrect.'], 401);
        }
    }
}

