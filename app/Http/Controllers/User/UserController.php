<?php

namespace App\Http\Controllers\User;

use App\Models\Club;
use App\Models\Player;
use App\Models\Comment;
use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    // direct user home page
    public function home(){
        $club = Club::when(request("key"),function($query){
            $query->where('name','like','%'.request('key').'%');
        })->orderBy('id','asc')->get();
        return view('users.main.home', compact('club'));
    }

    // direct route club detail
    public function clubDetail($id){
        $club = Club::find($id);
        $players = Player::select('players.*','clubs.name as club_name')
                    ->leftJoin('clubs','clubs.id','players.club_id')
                    ->where('club_id', $id)->get();
        return view('users.club.clubDetail', compact('club', 'players'));
    }

    // direct gallery List route
    public function blogList(){
        $galleries = Gallery::when(request('key'),function($query){
            $query->where('header','like','%'.request('key').'%');
        })->get();
        return view('users.blog.blog', compact('galleries'));
    }

    // direct gallery detail route
    public function blogDetail($id){
        $gallery = Gallery::find($id);
        $comments = Comment::select('comments.*','users.name as user_name','users.image as user_image')
                    ->leftJoin('users','comments.user_id','users.id')
                    ->where('gallery_id', $id)->get();
        return view('users.blog.blogDetail', compact('gallery', 'comments'));
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
