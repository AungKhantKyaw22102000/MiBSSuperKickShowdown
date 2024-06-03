@extends('admin.layout.master')

@section('title', 'Admin Club Details')

@section('content')

    <!-- club details -->
    <div class='club-details'>
        <div class='view-bg'>
            <div class='caption-title'>
                <img src='{{ asset('storage/clubPhoto/' . $club->club_photo) }}' style='width: 75px; height: 77px;'>
                <div class='title'><br>
                    <h3>{{ $club->name }}</h3>
                </div>
            </div>
        </div>
        <div class='container'>
            <div class='wrap-content'>
                <div class='row'>
                    <div class='col s12'>
                        <ul class='tabs'>
                            <li class='tab col s6'><a href='#tabs1'>Stats</a></li>
                            <li class='tab col s6'><a href='#tabs2'>Players</a></li>
                        </ul>
                    </div>
                    <div id='tabs1' class='col s12'>
                        <div class='contents-tabs'>
                            <div class='content content-stats'>
                                <ul>
                                    <li class='stripe'>Wins <span>{{ $club->win }}</span></li>
                                    <li>Goals <span>{{ $club->goal_for }}</span></li>
                                    <li class='stripe'>Draws <span>{{ $club->draw }}</span></li>
                                    <li>Losses <span>{{ $club->lose }}</span></li>
                                    <li class='stripe'>Play Match <span>{{ $club->played_match }}</span></li>
                                    <li>Yellow Card <i class='fas fa-square-full red-text'></i>
                                        <span>{{ $club->yellow_card }}</span>
                                    </li>
                                    <li class='stripe'>Red Card <i class='fas fa-square-full yellow-text text-darken-1'></i>
                                        <span>{{ $club->red_card }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div id='tabs2' class='col s12'>
                        <div class='contents-tabs'>
                            <div class='content-players'>
                                <div class='row'>
                                    <div class='col s3'>
                                        @foreach ($players as $player)
                                        <div class='content-image'>
                                            <img src='{{ asset('storage/playerPhoto/' . $player->player_photo) }}' alt=''>
                                                </div>
                                            </div>
                                            <div class='col s9'>
                                                <div class='content-text'>
                                                    <h6>
                                                        <a href='{{ route('admin#playerDetail', $player->id) }}'>{{$player->name}}</a>
                                                    </h6>
                                                    <p>Back Number - {{ $player->back_number }}</p>
                                                    <p>DoB - {{ $player->date_of_birth }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end club details -->

    @endsection
