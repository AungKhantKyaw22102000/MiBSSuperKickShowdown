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
            <div class='player-header'>
                <div class='image'>
                    <img src='player_photo/' alt=''>
                </div>
                <div class='title-name'>
                    <h2></h2>
                </div>
            </div>
            <div class='wrap-content'>
                <h4>Personal Details</h4>
                <div class='content'>
                    <ul>
                        <li class='stripe'>Club <span></span></li>
                        <li>DoB <span></span></li>
                        <li class='stripe'>Back Number <span></span></li>
                    </ul>
                </div>
            </div>
            <div class='wrap-content'>
                <h4>Statistics</h4>
                <div class='content'>
                    <ul>
                        <li class='stripe'>Goals <span></span></li>
                        <li>Assist <span></span></li>
                        <li class='stripe'>Yellow Card <i class='fas fa-square-full yellow-text'></i> <span></span></li>
                        <li>Red Card <i class='fas fa-square-full red-text text-darken-1'></i> <span></span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- end player-details -->
@endsection
