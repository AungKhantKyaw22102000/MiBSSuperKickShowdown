<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Club;
use App\Models\Vote;
use App\Models\Player;
use App\Models\Comment;
use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Models\FootballMatch;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

    public function blogList() {
        $galleriesQuery = Gallery::when(request('key'), function($query) {
            $query->where('header', 'like', '%' . request('key') . '%');
        })
        ->when(request('date') && request('date') != 'all', function($query) {
            $query->whereDate('created_at', request('date'));
        });
        $paginatedGalleries = $galleriesQuery->paginate(6);
        $groupedGalleries = $paginatedGalleries->getCollection()->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('d-M-Y');
        });
        $paginatedGalleries->setCollection($groupedGalleries);
        // Handle AJAX requests
        if (request()->ajax()) {
            $responseGalleries = $groupedGalleries->map(function ($group) {
                return $group->map(function ($gallery) {
                    return [
                        'header' => $gallery->header,
                        'sub_header' => $gallery->sub_header,
                        'created_at' => $gallery->created_at->format('d-M-Y'),
                        'first_photo_url' => asset('storage/galleryPhoto/' . $gallery->first_photo),
                        'detail_url' => route('user#blogDetail', $gallery->id),
                    ];
                });
            });

            return response()->json(['galleries' => $responseGalleries]);
        }

        return view('users.blog.blog', compact('paginatedGalleries'));
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
                                ->orderBy('play_date', 'desc')
                                ->get();
        $groupedMatches = $matches->groupBy('play_date');
        return view('users.matches.matches', compact('groupedMatches'));
    }

    // vote section
    public function createVote(Request $request) {
        // Check if the user is authenticated and their email is verified
        if (!Auth::check() || Auth::user()->is_verified === 0) {
            return response()->json([
                'error' => 'You need to verify your email before voting.'
            ], 403);
        }

        $validatedData = $request->validate([
            'matchId' => 'required|integer',
            'vote' => 'required|string|in:team1,team2,draw',
        ]);

        $userId = Auth::id(); // Assuming user is authenticated
        $matchId = $request->matchId;

        // Check if the user has already voted for this match today
        $existingVote = Vote::where('user_id', $userId)
                            ->where('match_id', $matchId)
                            ->whereDate('created_at', Carbon::today())
                            ->first();

        if ($existingVote) {
            return response()->json([
                'message' => 'You have already voted for this match today.'
            ], 403);
        }

        // Create a new vote
        $vote = new Vote();
        $vote->user_id = $userId;
        $vote->match_id = $matchId;
        $vote->option = $request->vote;
        $vote->save();

        // Get the updated vote counts for the match
        $totalVotes = Vote::where('match_id', $matchId)->count();
        $team1Votes = Vote::where('match_id', $matchId)->where('option', 'team1')->count();
        $team2Votes = Vote::where('match_id', $matchId)->where('option', 'team2')->count();
        $drawVotes = Vote::where('match_id', $matchId)->where('option', 'draw')->count();

        // Return the updated vote counts along with the success message
        return response()->json([
            'message' => 'Vote submitted successfully',
            'total' => $totalVotes,
            'team1' => $team1Votes,
            'team2' => $team2Votes,
            'draw' => $drawVotes,
        ]);
    }


    // show vote result
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

        // Fetch team names from the $match object or wherever they are stored
        $team1Name = Club::find($match->team1_id)->name ?? 'Team 1';
        $team2Name = Club::find($match->team2_id)->name ?? 'Team 2';

        return response()->json([
            'total' => $totalVotes,
            'team1' => $team1Votes,
            'team2' => $team2Votes,
            'draw' => $drawVotes,
            'team1_name' => $team1Name,
            'team2_name' => $team2Name,
        ]);
    }

    // player direct route
    public function playerList() {
        $players = Player::select('players.*', 'clubs.name as club_name', 'clubs.club_photo as club_photo')
            ->when(request('key'), function($query) {
                $query->where('players.name', 'like', '%' . request('key') . '%');
            })
            ->when(request('team') && request('team') != 'all', function($query) {
                $query->where('clubs.name', request('team'));
            })
            ->leftJoin('clubs', 'players.club_id', 'clubs.id')
            ->paginate(10);

        $players->appends(request()->all());

        if (request()->ajax()) {
            $players->getCollection()->transform(function ($player) {
                $player->player_photo_url = asset('storage/playerPhoto/' . $player->player_photo);
                $player->club_photo_url = asset('storage/clubPhoto/' . $player->club_photo);
                $player->detail_url = route('user#playerDetail', $player->id);
                $player->club_detail_url = route('user#clubDetail', $player->club_id);
                return $player;
            });
            return response()->json(['players' => $players]);
        }

        return view('users.players.player', compact('players'));
    }


    // direct player detail route
    public function playerDetail($id){
        $player = Player::select('players.*','clubs.name as club_name')
                ->leftjoin('clubs','players.club_id','clubs.id')
                ->where('players.id',$id)
                ->first();
        return view('users.players.playerDetail', compact('player'));
    }

    // direct user profile route
    public function profile(){
        return view('users.profile.profile');
    }

    // direct route profile verify
    public function profileVerify(){
        return view('auth.verify');
    }

    // update profile
    public function updateProfile($id, Request $request){
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
        return redirect()->route('user#profile');
    }

    // direct user change password route
    public function userChangePasswordPage(){
        return view('users.profile.changePassword');
    }

    // user change password
    public function userChangePassword(Request $request){
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

    // direct user result page
    public function resultList(){
        $matches = FootballMatch::select('football_matches.*',
                                         'team1.name as team1_name',
                                         'team1.club_photo as team1_photo',
                                         'team2.name as team2_name',
                                         'team2.club_photo as team2_photo')
                                ->leftJoin('clubs as team1', 'football_matches.team1_id', 'team1.id')
                                ->leftJoin('clubs as team2', 'football_matches.team2_id', 'team2.id')
                                ->where('finished', 1)
                                ->orderBy('play_date', 'desc')
                                ->get();
        $groupedMatches = $matches->groupBy('play_date');
        return view('users.result.result', compact('groupedMatches'));
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
