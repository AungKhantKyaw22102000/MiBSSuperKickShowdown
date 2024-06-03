<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PlayerController extends Controller
{
    // direct player list route
    public function playerList(){
        $players = Player::select('players.*','clubs.name as club_name')
                ->when(request('key'),function($query){
                    $query->where('players.name','like','%'.request('key').'%');
                })
                ->leftjoin('clubs','players.club_id','clubs.id')
                ->paginate(10);
                $players->appends(request()->all());
        return view('admin.player.playerList', compact('players'));
    }

    // direct create player route
    public function playerCreatePage(){
        $clubs = Club::select('id','name')->get();
        return view('admin.player.create', compact('clubs'));
    }

    // direct player detail route
    public function playerDetail($id){
        $player = Player::select('players.*','clubs.name as club_name')
                ->leftjoin('clubs','players.club_id','clubs.id')
                ->where('players.id',$id)
                ->first();
        return view('admin.player.detail', compact('player'));
    }

    // direct player update route
    public function playerUpdatePage($id){
        $players = Player::where('id',$id)->first();
        $clubs = Club::get();
        return view('admin.player.update', compact('clubs','players'));
    }

    // create player
    public function playerCreate(Request $request){
        $this->playerValidationCheck($request, 'create');
        $data = $this->playerRequestData($request);
        $fileName = uniqid() . $request->file('playerPhoto')->getClientOriginalName();
        $request->file('playerPhoto')->storeAs('public/playerPhoto',$fileName);
        $data['player_photo'] = $fileName;

        Player::create($data);
        return redirect()->route('admin#playerList');
    }

    // delete player
    public function playerDelete($id){
        $player = Player::find($id);
        if($player){
            Storage::delete('public/playerPhoto/' . $player->player_photo);
            $player->delete();
        }
        return back()->with(['deleteSuccess'=>'Selected Playerd is Deleted Successfully...']);
    }

    // player update
    public function playerUpdate(Request $request){
        $this->playerValidationCheck($request, 'update');
        $data = $this->playerRequestData($request);

        if($request->hasFile('playerPhoto')){
            $oldImageName = Player::where('id',$request->playerId)->first();
            $oldImageName = $oldImageName->player_photo;

            if($oldImageName != null){
                Storage::delete('public/playerPhoto/'.$oldImageName);
            }
            $fileName = uniqid().$request->file('playerPhoto')->getClientOriginalName();
            $request->file('playerPhoto')->storeAs('public/playerPhoto',$fileName);
            $data['player_photo'] = $fileName;
        }
        Player::where('id', $request->playerId)->update($data);
        return redirect()->route('admin#playerList');
    }

    // player validation check
    private function playerValidationCheck($request, $action){
        $validationRules = [
            'playerName' => 'required|min:3',
            'backNumber' => 'required|integer',
            'playerGoal' => 'required|integer',
            'playerAssist' => 'required|integer',
            'playerClub' => 'required',
            'playerYellowCard' => 'required|integer',
            'playerRedCard' => 'required|integer',
        ];
        $validationRule['playerPhoto'] = $action == "create" ? "required|mimes:jpg,png,jpeg,webp|file" : "mimes:jpg,png,jpeg|file";

        Validator::make($request->all(),$validationRules,[])->validate();
    }

    // player request data
    private function playerRequestData($request){
        return [
            'name' => $request->playerName,
            'back_number' => $request->backNumber,
            'goal' => $request->playerGoal,
            'assist' => $request->playerAssist,
            'club_id' => $request->playerClub,
            'yellow_card' => $request->playerYellowCard,
            'red_card' => $request->playerRedCard,
            'date_of_birth' => $request->dateOfBirth,
        ];
    }
}
