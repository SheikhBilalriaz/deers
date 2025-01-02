<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmailVerification;
use App\Mail\opt_sender;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    public function apiRegister(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }
    public function register(Request $request)
    {
        // echo $request->user_role;
        // exit;
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());


        session(['User_id' => $user->id]);
        return redirect()->route("home");

    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }


    protected function create(array $data)
    {
        return User::create([

            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['user_role'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function sendOtp($user)
    {
        $otp = rand(100000,999999);
        $time = time();

        EmailVerification::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'otp' => $otp,
                'created_at' => $time
            ]
        );

        $mailData =
            [
                "title" => 'Mail Verification',
                'body' => 'Your OTP is:- '.$otp,
            ];
        Mail::to($user->email)->send(new opt_sender($mailData));

    }
    public function verify_otp(Request $request){

        $user = User::where('id',$request->id)->first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Not Allowed To Access This Page.'], 401);
        }

        if (Auth::check() && $user->is_verified == 1) {
            return response()->json(['success' => true, 'message' => 'user Logged In', 'data'=>$user], 200);
        }

        $this->sendOtp($user);
        return response()->json(['success' => true, 'message' => 'Otp Send To your Account', 'data'=>$user], 200);

    }
    public function verifiedOtp(Request $request)
    {
        $user = User::where('id',$request->id)->first();
        $otpData = EmailVerification::where('otp',$request->otp)
            ->where('email',$user->email)
            ->first();

        if(!$otpData){
            return response()->json(['success' => false, 'message' => 'Invalid OTP.'], 401);
        }
        else{

            $currentTime = time();
            $time = $otpData->created_at;

            if($currentTime >= $time && $time >= $currentTime - (90+5)){
                User::where('id',$user->id)->update([
                    'is_verified' => 1
                ]);
                return response()->json(['success' => true, 'message' => 'user Logged In', 'data'=>$user], 200);
            }
            else{
                return response()->json(['success' => false, 'message' => 'Your OTP has been Expired'], 401);
            }

        }
    }
    public function resendOtp(Request $request)
    {
        $user = User::where('id',$request->id)->first();
        $otpData = EmailVerification::where('email',$user->email)->first();

        $currentTime = time();
        $time = $otpData->created_at;

        if($currentTime >= $time && $time >= $currentTime - (30)){
            return response()->json(['success' => false, 'message' => 'Please try after some time'], 401);
        }
        else{
            $this->sendOtp($user);
            return response()->json(['success' => true, 'message' => 'OTP Send To your Account'], 200);
        }

    }
}
