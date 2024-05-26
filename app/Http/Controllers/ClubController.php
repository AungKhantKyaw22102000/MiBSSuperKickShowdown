<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClubController extends Controller
{
    // direct route club list
    public function clubList(){
        return view('admin.club.clubList');
    }
}
