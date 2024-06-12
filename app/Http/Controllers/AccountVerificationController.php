<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\EmailVerification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Actions\Fortify\CreateNewUser;

class AccountVerificationController extends Controller
{
    public function register(Request $request){
        $createUserAction = app(CreateNewUser::class);
        $user = $createUserAction->create($request->all());

        // Send email verification after registration
        if ($user) {
            $this->sendOtp($user);
            return redirect("auth.vefiry" . $user->id);
        }

        // Handle registration failure
        return back()->with('error', 'Registration failed');
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

        $data['email'] = $user->email;
        $data['title'] = 'Mail Verification';

        $data['body'] = 'Your OTP is:- '.$otp;

        Mail::send('mailVerification',['data'=>$data],function($message) use ($data){
            $message->to($data['email'])->subject($data['title']);
        });
    }

    public function userLogin(Request $request)
    {
        $request->validate([
            'email' => 'string|required|email',
            'password' => 'string|required'
        ]);

        $userCredential = $request->only('email','password');
        $userData = User::where('email',$request->email)->first();
        if($userData && $userData->is_verified == 0){
            $this->sendOtp($userData);
            return redirect("auth.vefiry".$userData->id);
        }
        else if(Auth::attempt($userCredential)){
            return redirect()->rotue('user#homePage');
        }
        else{
            return back()->with('error','Username & Password is incorrect');
        }
    }

    public function verification($id)
    {
        $user = User::where('id',$id)->first();
        if(!$user || $user->is_verified == 1){
            return redirect()->route('user#homePage');
        }
        $email = $user->email;

        $this->sendOtp($user);//OTP SEND

        return view('verification',compact('email'));
    }

    public function verifiedOtp(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        $otpData = EmailVerification::where('otp',$request->otp)->first();
        if(!$otpData){
            return response()->json(['success' => false,'msg'=> 'You entered wrong OTP']);
        }
        else{

            $currentTime = time();
            $time = $otpData->created_at;

            if($currentTime >= $time && $time >= $currentTime - (90+5)){//90 seconds
                User::where('id',$user->id)->update([
                    'is_verified' => 1
                ]);
                return response()->json(['success' => true,'msg'=> 'Mail has been verified']);
            }
            else{
                return response()->json(['success' => false,'msg'=> 'Your OTP has been Expired']);
            }

        }
    }

    public function resendOtp(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        $otpData = EmailVerification::where('email',$request->email)->first();

        $currentTime = time();
        $time = $otpData->created_at;

        if($currentTime >= $time && $time >= $currentTime - (90+5)){//90 seconds
            return response()->json(['success' => false,'msg'=> 'Please try after some time']);
        }
        else{

            $this->sendOtp($user);//OTP SEND
            return response()->json(['success' => true,'msg'=> 'OTP has been sent']);
        }

    }
}
