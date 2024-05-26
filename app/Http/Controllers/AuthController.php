<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // direct login page
    public function loginPage(){
        return view('login');
    }

    // direct register page
    public function registerPage(){
        return view('register');
    }

    // direct admin dashbaord page
    public function adminDashboard(){
        if(Auth::user()->role == 'admin'){
            return redirect()->route('admin#clubList');
        }
    }

    // direct user dashboard page
    public function userDashboard(){
        if(Auth::user()->role == 'user'){
            return redirect()->route('user#home');
        }
    }

}
