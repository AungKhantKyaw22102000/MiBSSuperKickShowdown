@extends('users.layouts.master')

@section('title', 'Player Detail')

@section('search')
<!-- search -->
<div id="modal1" class="modal">
    <div class="modal-content">
        <form id="player-search-form" method="get">
            @csrf
            <input type="text" name="key" value="{{ request('key') }}" id="search-input" placeholder="Search">
            <button class="button" id="search-button">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>
<!-- end search -->
@endsection

@section('content')
    <!-- player-details -->
    <div class='player-details segments-page'>
        <div class='container'>
            <div class="row">
                <div class="col-3 offset-8">
                    <span onclick="history.back()"><i class="fa-solid fa-backward text-dark"></i> Back</span>
                </div>
            </div>
            <div class='player-header'>
                <div class='image'>
                    <img src='{{ asset('storage/playerPhoto/'.$player->player_photo) }}' alt='{{ $player->name }}'>
                </div>
                <div class='title-name'>
                    <h2>{{ $player->name }}</h2>
                </div>
            </div>
            <div class='wrap-content'>
                <h4>Personal Details</h4>
                <div class='content'>
                    <ul>
                        <li class='stripe'>Club <span>{{ $player->club_name }}</span></li>
                        <li>DoB  <span>{{ \Carbon\Carbon::parse($player->date_of_birth)->format('M-d-Y') }}</span></li>
                        <li class='stripe'>Back Number <span>{{ $player->back_number }}</span></li>
                    </ul>
                </div>
            </div>

            <div class='wrap-content'>
                <h4>Statistics</h4>
                <div class='content'>
                    <ul>
                        <li class='stripe'>Goals <span>{{ $player->goal }}</span></li>
                        <li>Assist <span>{{ $player->assist }}</span></li>
                        <li class='stripe'>Yellow Card <i class='fas fa-square-full yellow-text'></i> <span>{{ $player->yellow_card }}</span></li>
                        <li>Red Card <i class='fas fa-square-full red-text text-darken-1'></i> <span>{{ $player->red_card }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- end player-details -->
@endsection

