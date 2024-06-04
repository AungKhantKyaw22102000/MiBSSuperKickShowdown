<?php

namespace App\Http\Controllers\User;

use App\Models\Club;
use App\Models\Vote;
use App\Models\Player;
use App\Models\Comment;
use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Models\FootballMatch;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

    // comment section
    public function commentCreate(Request $request){
        $comment = $this->commentRequestData($request);
        Comment::create($comment);
        return back();
    }

    // direct user club list page
    public function clubList(){
        return view('users.club.clubList');
    }

    // Direct football match route
    public function matchList() {
        $matches = FootballMatch::select('football_matches.*',
                                         'team1.name as team1_name',
                                         'team1.club_photo as team1_photo',
                                         'team2.name as team2_name',
                                         'team2.club_photo as team2_photo')
                                ->leftJoin('clubs as team1', 'football_matches.team1_id', 'team1.id')
                                ->leftJoin('clubs as team2', 'football_matches.team2_id', 'team2.id')
                                ->when(request('key'), function ($query) {
                                    $key = request('key');
                                    $query->where(function ($q) use ($key) {
                                        $q->where('team1.name', 'like', '%' . $key . '%')
                                          ->orWhere('team2.name', 'like', '%' . $key . '%');
                                    });
                                })
                                ->where(function ($query) {
                                    $query->where('finished', 0)
                                          ->orWhereNull('finished');
                                })
                                ->orderBy('created_at', 'desc')
                                ->get();

        return view('users.matches.matches', compact('matches'));
    }

    // vote section
    public function createVote(Request $request)
    {
        $userId = Auth::id();
        $matchId = $request->input('match_id');
        $selectedOption = $request->input('vote');
        $currentDate = now()->toDateString();

        $match = FootballMatch::find($matchId);

        if (!$match || $match->play_date < $currentDate) {
            return response()->json(['error' => 'The voting period for this match has ended.'], 403);
        }

        $existingVote = Vote::where('user_id', $userId)
                            ->where('match_id', $matchId)
                            ->whereDate('created_at', $currentDate)
                            ->first();

        if ($existingVote) {
            return response()->json(['error' => 'You can only vote once per day.'], 403);
        }

        $vote = new Vote();
        $vote->user_id = $userId;
        $vote->match_id = $matchId;
        $vote->option = $selectedOption;
        $vote->save();

        return response()->json(['message' => 'Vote submitted successfully!']);
    }

    public function showResults($matchId)
    {
        $match = FootballMatch::find($matchId);
        if (!$match) {
            return response()->json(['error' => 'Match not found.'], 404);
        }

        $totalVotes = Vote::where('match_id', $matchId)->count();
        $team1Votes = Vote::where('match_id', $matchId)->where('option', 'team1')->count();
        $team2Votes = Vote::where('match_id', $matchId)->where('option', 'team2')->count();
        $drawVotes = Vote::where('match_id', $matchId)->where('option', 'draw')->count();

        return response()->json([
            'total' => $totalVotes,
            'team1' => $team1Votes,
            'team2' => $team2Votes,
            'draw' => $drawVotes,
        ]);
    }

    // direct player list route
    public function playerList(){
        $players = Player::select('players.*','clubs.name as club_name', 'clubs.club_photo as club_photo')
                ->when(request('key'),function($query){
                    $query->where('players.name','like','%'.request('key').'%');
                })
                ->leftjoin('clubs','players.club_id','clubs.id')
                ->paginate(10);
                $players->appends(request()->all());
        return view('users.players.player', compact('players'));
    }

    // direct player detail route
    public function playerDetail($id){
        $player = Player::select('players.*','clubs.name as club_name')
                ->leftjoin('clubs','players.club_id','clubs.id')
                ->where('players.id',$id)
                ->first();
        return view('admin.player.detail', compact('player'));
    }

    // direct user result page
    public function resultList(){
        return view('users.result.result');
    }

    // direct user stats page
    public function statList(){
        $goals = Player::select('players.*','clubs.name as club_name', 'clubs.club_photo as club_photo')
                ->leftJoin('clubs','clubs.id','players.club_id')
                ->orderBy('goal', 'desc')->get();
        $assists = Player::select('players.*','clubs.name as club_name', 'clubs.club_photo as club_photo')
                ->leftJoin('clubs','clubs.id','players.club_id')
                ->orderBy('assist', 'desc')->get();
        return view('users.stats.stats', compact('goals', 'assists'));
    }

    // comment request data
    private function commentRequestData($request){
        return[
            'comment' => $request->commentMessage,
            'gallery_id' => $request->galleryId,
            'user_id' => $request->userId, 
        ];
    }

}
