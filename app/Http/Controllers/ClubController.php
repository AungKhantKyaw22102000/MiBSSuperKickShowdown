<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ClubController extends Controller
{
    // direct route club list
    public function clubList(){
        $club = Club::when(request("key"),function($query){
            $query->where('name','like','%'.request('key').'%');
        })->orderBy('id','asc')->get();
        return view('admin.club.clubList', compact('club'));
    }

    // direct route club create
    public function clubCreatePage(){
        return view('admin.club.create');
    }

    // direct route club detail
    public function clubDetail($id){
        $club = Club::find($id);
        $players = Player::select('players.*','clubs.name as club_name')
                    ->leftJoin('clubs','clubs.id','players.club_id')
                    ->where('club_id', $id)->get();
        return view('admin.club.detail', compact('club', 'players'));
    }

    // direct route club update
    public function clubUpdatePage($id){
        $club = Club::where('id',$id)->first();
        return view('admin.club.update', compact('club'));
    }

    // create club
    public function clubCreate(Request $request){
        $this->clubCreateValidationCheck($request,"create");
        $club = $this->requestClubData($request);
        $fileName = uniqid() . $request->file('clubPhoto')->getClientOriginalName();
        $request->file('clubPhoto')->storeAs('public/clubPhoto',$fileName);
        $club['club_photo'] = $fileName;

        Club::create($club);
        return redirect()->route('admin#clubList');
    }

    // update club
    public function clubUpdate(Request $request){
        $this->clubCreateValidationCheck($request, 'update');
        $data = $this->requestClubData($request);

        if($request->hasFile('clubPhoto')){
            $oldImageName = Club::where('id',$request->clubId)->first();
            $oldImageName = $oldImageName->club_photo;

            if($oldImageName != null){
                Storage::delete('public/clubPhoto/'.$oldImageName);
            }
            $fileName = uniqid().$request->file('clubPhoto')->getClientOriginalName();
            $request->file('clubPhoto')->storeAs('public/clubPhoto',$fileName);
            $data['club_photo'] = $fileName;
        }
        Club::where('id',$request->clubId)->update($data);
        return redirect()->route('admin#clubList');
    }

    // delete club
    public function clubDelete($id){
        $club = Club::find($id);
        if($club){
            Storage::delete('public/clubPhoto/' . $club->club_photo);
            $club->delete();
        }
        return back()->with(['deleteSuccess'=>'Selected Club is Deleted Successfully...']);
    }

    // Club Crete Validation Check
    private function clubCreateValidationCheck($request, $action){
        $validationRule = [
            'clubName' => 'required|min:3|unique:clubs,name,'.$request->clubId,
            'playedMatch' => 'nullable|integer',
            'winMatch' => 'nullable|integer',
            'drawMatch' => 'nullable|integer',
            'lose' => 'nullable|integer',
            'goalFor' => 'nullable|integer',
            'goalAgainst' => 'nullable|integer',
            'point' => 'nullable|integer'
        ];
        $validationRule['clubPhoto'] = $action == "create" ? "required|mimes:jpg,png,jpeg,webp|file" : "mimes:jpg,png,jpeg,webp|file";
        Validator::make($request->all(),$validationRule,)->validate();
    }

    // request club data
    private function requestClubData($request){
        return [
            'name' => $request->clubName,
            'played_match' => $request->playedMatch,
            'win' => $request->winMatch,
            'draw' => $request->drawMatch,
            'lose' => $request->loseMatch,
            'goal_for' => $request->goalFor,
            'goal_against' => $request->goalAgainst,
            'points' => $request->point
        ];
    }
}
