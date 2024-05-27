<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // direct user home page
    public function home(){
        return view('users.main.home');
    }

    // direct user blog list page
    public function blogList(){
        return view('users.blog.blog');
    }

    // direct user club list page
    public function clubList(){
        return view('users.club.clubList');
    }

    // direct user contact page
    public function contact(){
        return view('users.contact.contact');
    }

    // direct user match page
    public function matchList(){
        return view('users.matches.matches');
    }

    // direct user player page
    public function playerList(){
        return view('users.players.player');
    }

    // direct user result page
    public function resultList(){
        return view('users.result.result');
    }

    // direct user stats page
    public function statList(){
        return view('users.stats.stats');
    }
}
