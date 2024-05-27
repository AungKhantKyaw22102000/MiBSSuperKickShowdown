<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlayerController extends Controller
{
    // direct player route
    public function playerList(){
        return view('admin.player.playerList');
    }
}
