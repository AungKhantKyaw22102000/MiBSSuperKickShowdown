<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ForgotPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    // direct route forgot password
    public function forgotPasswordPage(){
        return view('auth.forgotPassword');
    }

    // forgot password
    public function forgotPassword(Request $request){
        $this->forgotPasswordValidation($request);
        $token = Str::random(64);
        $this->requestForgetPassword($request, $token);

        Mail::send("emails.forget-password", ['token' => $token], function ($message) use ($request){
            $message->to($request->email);
            $message->subject("Reset Password");
        });

        return redirect()->route('auth#forgotPasswordPage')->with(["success"=>"We have sent an email to reset your password."]);
    }

    public function resetPassword($token){
        $forgotPassword = ForgotPassword::where('token', $token)->first();

        if (!$forgotPassword || Carbon::now()->greaterThan($forgotPassword->expires_at)) {
            return redirect()->route('auth#forgotPasswordPage')->with(["error" => "Invalid or expired token. Please request a new password reset."]);
        }

        return view('auth.newPassword', compact('token'));
    }

    public function resetPasswordPost(Request $request){
        $this->resetPasswordValidation($request);

        $updatePassword = ForgotPassword::where([
            "email" => $request->email,
            "token" => $request->token,
        ])->first();

        if(!$updatePassword || Carbon::now()->greaterThan($updatePassword->expires_at)){
            return redirect()->route('auth#forgotPasswordPage')->with(["error"=>"Invalid or expired token. Please request a new password reset."]);
        }

        User::where("email", $request->email)->update(["password" => Hash::make($request->password)]);
        ForgotPassword::where(["email" => $request->email])->delete();
        return redirect()->route("login")->with(['success'=>"Password reset successful"]);
    }

    // forgot password validation
    private function forgotPasswordValidation($request){
        Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ])->validate();
    }

    // reset password validation
    private function resetPasswordValidation($request){
        Validator::make($request->all(),[
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ])->validate();
    }

    // request forget password data
    private function requestForgetPassword($request, $token){
        ForgotPassword::create([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addMinutes(60), // Token expires in 60 minutes
        ]);
    }
}
