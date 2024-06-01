<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // direct admin profile route
    public function adminProfile(){
        return view('admin.profile.adminProfile');
    }

    // direct change password route
    public function adminChangePasswordPage(){
        return view('admin.profile.changePassword');
    }

    // direct user list route
    public function userList(){
        $admin = User::paginate(20);
        return view('admin.profile.userList', compact('admin'));
    }

    // change password
    public function adminChangePassword(Request $request){
        $this->passwordValidationCheck($request);
        $currentUserId = Auth::user()->id;
        $user = User::select('password')->where('id',$currentUserId)->first();
        $dbPassword = $user->password;

        if(Hash::check($request->oldPassword, $dbPassword)){
            User::where('id', $currentUserId)->update([
                'password' => Hash::make($request->newPassword)
            ]);
            return back();
        }
        return back()->with(['notMatch' => 'The old Password Not Match. Try Again!']);
    }

    // admin profile update
    public function adminUpdate($id, Request $request){
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);
        if($request->hasFile('userPhoto')){
            $dbImage = User::where('id',$id)->first();
            $dbImage = $dbImage->image;

            if($dbImage != null){
                Storage::delete('public/userPhoto/'.$dbImage);
            }

            $fileName = uniqid() . $request->file('userPhoto')->getClientOriginalName();
            $request->file('userPhoto')->storeAs('public/userPhoto', $fileName);
            $data['image'] = $fileName;
        }
        User::where('id',$id)->update($data);
        return redirect()->route('admin#adminProfile');
    }

    // account validation check
    private function accountValidationCheck($request){
        Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'image' => 'mimes:png,jpg,jpeg,webp|file',
        ])->validate();
    }

    // get user data
    private function getUserData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
        ];
    }

    // password validation check
    private function passwordValidationCheck($request){
        Validator::make($request->all(),[
            'oldPassword' => 'required|min:6',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|min:6|same:newPassword',
        ])->validate();
    }
}
