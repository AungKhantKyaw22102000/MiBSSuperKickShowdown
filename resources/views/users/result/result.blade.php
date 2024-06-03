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
            <div class='wrap-content'>
                <div class='row'>
                    <div class='col s8'>
                        <div class='content-left'>
                            <ul>
                                <li><a href='club-details.php?viewteam=" . $c1_id . "'><img src='photo/'
                                            style='width: 18px; height: 18px;'></a></li>
                                <li><a href='club-details.php?viewteam=" . $c2_id . "'><img src='photo/'
                                            style='width: 18px; height: 18px;'></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class='col s4'>
                        <div class='content-right'>
                            <ul>
                                <li></li>
                                <li style='color: #000'></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end matches -->
@endsection
