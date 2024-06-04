@extends('users.layouts.master')

@section('title', 'Players')

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

    <!-- players -->
    <div class='players segments-page'>
        <div class='container'>
            <div class='wrap-title'>
                <h4>Players</h4>
            </div>

            @foreach ($players as $p)
            <div class='row'>
                <div class='col s3'>
                    <div class='content-image'>
                        <img src='{{ asset('storage/playerPhoto/' . $p->player_photo) }}' alt='{{ $p->name }}'>
                    </div>
                </div>
                <div class='col s9'>
                    <div class='content-text'>
                        <a href='{{ route('user#playerDetail', $p->id) }}'>
                            <h6>{{ $p->name }}</h6>
                        </a>
                        <p></p>
                        <a href='{{ route('user#clubDetail', $p->club_id) }}'>
                            <img alt="{{ $p->club_name }}" src='{{ asset('storage/clubPhoto/' . $p->club_photo) }}' style='width: 18px; height: 18px;'>
                            <span>{{ $p->club_name }}</span>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- end players -->

@endsection
