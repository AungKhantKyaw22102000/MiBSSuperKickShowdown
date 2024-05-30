<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Club;
use Illuminate\Http\Request;
use App\Models\FootballMatch;
use Illuminate\Support\Facades\Validator;

class FootballMatchController extends Controller
{
    // Direct football match route
    public function footballMatchList(){
        $matches = FootballMatch::select('football_matches.*',
                                         'team1.name as team1_name',
                                         'team1.club_photo as team1_photo',
                                         'team2.name as team2_name',
                                         'team2.club_photo as team2_photo')
                                ->leftJoin('clubs as team1', 'football_matches.team1_id', 'team1.id')
                                ->leftJoin('clubs as team2', 'football_matches.team2_id', 'team2.id')
                                ->where(function($query) {
                                    $query->where('finished', 0)
                                          ->orWhereNull('finished');
                                })
                                ->orderBy('created_at', 'desc')
                                ->get();
        return view('admin.match.matchList', compact('matches'));
    }

    // Direct football match result route
    public function footballMatchResultList(){
        $matches = FootballMatch::select('football_matches.*',
                                         'team1.name as team1_name',
                                         'team1.club_photo as team1_photo',
                                         'team2.name as team2_name',
                                         'team2.club_photo as team2_photo')
                                ->leftJoin('clubs as team1', 'football_matches.team1_id', 'team1.id')
                                ->leftJoin('clubs as team2', 'football_matches.team2_id', 'team2.id')
                                ->where('finished', 1)
                                ->orderBy('created_at', 'desc')
                                ->get();
        return view('admin.result.result', compact('matches'));
    }

    // direct football match create route
    public function footballMatchCreatePage(){
        $clubs = Club::get();
        return view('admin.match.create', compact('clubs'));
    }

    // direct football match update route
    public function footballMatchUpdatePage($id){
        $match = FootballMatch::where('id',$id)->first();
        $club = Club::get();
        return view('admin.match.update', compact('match', 'club'));
    }

    // create football match
    public function footballMatchCreate(Request $request){
        $this->footballMatchValidationCheck($request, 'create');
        $data = $this->footballMatchRequestData($request);
        FootballMatch::create($data);
        return redirect()->route('admin#footballMatchList');
    }

    // delete football match
    public function footballMatchDelete($id){
        FootballMatch::where('id',$id)->delete();
        return back()->with(['deleteSuccess' => 'Matched Deleted...']);
    }

    // Update football match
    public function footballMatchUpdate(Request $request){
        $this->footballMatchValidationCheck($request, 'update');
        $data = $this->footballMatchUpdateData($request);
        $match = FootballMatch::find($request->matchId);
        $match->update($data);
        $team1Points = 0;
        $team2Points = 0;
        $team1Result = 'draw'; // Can be 'win', 'draw', or 'lose'
        $team2Result = 'draw';
        if ($data['team1_goal'] > $data['team2_goal']) {
            $team1Points = 3;
            $team2Points = 0;
            $team1Result = 'win';
            $team2Result = 'lose';
        } elseif ($data['team1_goal'] < $data['team2_goal']) {
            $team1Points = 0;
            $team2Points = 3;
            $team1Result = 'lose';
            $team2Result = 'win';
        } else {
            $team1Points = 1;
            $team2Points = 1;
            $team1Result = 'draw';
            $team2Result = 'draw';
        }
        $this->updateClubPointsAndCards($data['team1_id'], $team1Points, $data['team1_yellow_card'], $data['team1_red_card'], $team1Result, $data['team1_goal'], $data['team2_goal']);
        $this->updateClubPointsAndCards($data['team2_id'], $team2Points, $data['team2_yellow_card'], $data['team2_red_card'], $team2Result, $data['team2_goal'], $data['team1_goal']);
        return redirect()->route('admin#footballMatchList')->with(['updateSuccess' => 'Football match updated successfully.']);
    }

    // Update club points, cards, match results, and goals
    private function updateClubPointsAndCards($clubId, $points, $yellowCards, $redCards, $result, $goalsFor, $goalsAgainst) {
        $club = Club::find($clubId);
        $club->points += $points;
        $club->yellow_card += $yellowCards;
        $club->red_card += $redCards;
        $club->goal_for += $goalsFor;
        $club->goal_against += $goalsAgainst;
        $club->goal_difference += ($goalsFor - $goalsAgainst);

        if ($result == 'win') {
            $club->win += 1;
        } elseif ($result == 'draw') {
            $club->draw += 1;
        } elseif ($result == 'lose') {
            $club->lose += 1;
        }
        $club->played_match += 1;
        $club->save();
    }

    // Football match validation check
    private function footballMatchValidationCheck($request, $action){
        $validationRule = [
            'playDate' => 'required',
            'firstTeam' => 'required|different:secondTeam',
            'secondTeam' => 'required',
            'playTime' => 'required',
        ];

        Validator::make($request->all(), $validationRule, [
            'firstTeam.different' => 'The first team and the second team must be different.'
        ])->validate();
    }

    // football Match Request Data
    private function footballMatchRequestData($request){
        return [
            'play_date' => $request->playDate,
            'play_time' => $request->playTime,
            'team1_id' => $request->firstTeam,
            'team2_id' => $request->secondTeam,
        ];
    }

    // football match update data
    private function footballMatchUpdateData($request){
        $finished = $request->has('finished') ? 1 : 0;
        return [
            'play_date' => $request->playDate,
            'play_time' => $request->playTime,
            'team1_id' => $request->firstTeam,
            'team1_goal' => $request->firstTeamGoal,
            'team1_yellow_card' => $request->firstTeamYellowCard,
            'team1_red_card' => $request->firstTeamRedCard,
            'team2_id' => $request->secondTeam,
            'team2_goal' => $request->secondTeamGoal,
            'team2_yellow_card' => $request->secondTeamYellowCard,
            'team2_red_card' => $request->secondTeamRedCard,
            'finished' => $finished,
        ];
    }
}
