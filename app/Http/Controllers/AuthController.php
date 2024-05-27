<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // direct login page
    public function loginPage(){
        return view('auth.login');
    }

    // direct register page
    public function registerPage(){
        return view('auth.register');
    }

    // direct admin dashbaord page
    public function adminDashboard(){
        if(Auth::user()->role == 'admin'){
            return redirect()->route('admin#clubList');
        } else{
            return redirect()->route('user#homePage');
        }
    }
}
