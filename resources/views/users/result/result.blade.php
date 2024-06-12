@extends('users.layouts.master')

@section('title', 'Match Result')

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
    <!-- matches -->
    <div class="matches segments-page">
        <div class="container">
            @foreach ($groupedMatches as $date => $matches)
            <div class="wrap-title">
                <h4>{{ \Carbon\Carbon::parse($date)->format('M-d-Y') }}</h4>
            </div>

                @foreach ($matches as $m)
                <div class='wrap-content'>
                    <div class='row'>
                        <div class='col s8'>
                            <div class='content-left'>
                                <ul>
                                    <li>
                                        <a href='{{ route("user#clubDetail", $m->team1_id) }}'>
                                            <img src='{{ asset('storage/clubPhoto/' . $match->team1_photo) }}'style='width: 18px; height: 18px;'>
                                            <span>{{ $m->team1_name }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href='{{ route("user#clubDetail", $m->team2_id) }}'>
                                            <img src='{{ asset('storage/clubPhoto/' . $m->team2_photo) }}'style='width: 18px; height: 18px;'>
                                            <span>{{ $m->team2_name }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class='col s4'>
                            <div class='content-right'>
                                <ul>
                                    <li>{{ $m->team1_goal }}</li>
                                    <li style='color: #000'>{{ $m->team2_goal }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            @endforeach
        </div>
    </div>
    <!-- end matches -->
@endsection
