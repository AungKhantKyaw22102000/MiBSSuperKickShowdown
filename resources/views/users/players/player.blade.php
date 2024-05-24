@extends('users.layouts.master')

@section('title', 'Players')

@section('content')

    <!-- players -->
    <div class='players segments-page'>
        <div class='container'>
            <div class='wrap-title'>
                <h4>Players</h4>
            </div>

            <div class='row'>
                <div class='col s3'>
                    <div class='content-image'>
                        <img src='player_photo/' alt=''>
                    </div>
                </div>
                <div class='col s9'>
                    <div class='content-text'>
                        <a href='player-details.php?viewplayer=" . $id . "'>
                            <h6></h6>
                        </a>
                        <p></p>
                        <a href='club-details.php?viewteam=" . $c_id . "'>
                            <img src='photo/' style='width: 18px; height: 18px;'>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end players -->

@endsection
