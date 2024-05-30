<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // direct admin profile route
    public function adminProfile(){
        return view('admin.profile.adminProfile');
    }
}
