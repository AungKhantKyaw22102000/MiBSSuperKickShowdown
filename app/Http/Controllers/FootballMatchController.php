<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FootballMatchController extends Controller
{
    // direct football match route
    public function footballMatchList(){
        return view('admin.match.matchList');
    }
}
