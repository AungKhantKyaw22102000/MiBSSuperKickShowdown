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
        <div class="wrap-filter">
            <h6>Filter By Team</h6><br>
            <select class="browser-default" id="teamFilter">
                <option value="all">All Teams</option>
                @foreach ($players->groupBy('club_name') as $club_name => $group)
                    <option value="{{ $club_name }}" @if(request('team') == $club_name) selected @endif>
                        {{ $club_name }}
                    </option>
                @endforeach
            </select>
        </div><br>

        <div class="player-container">
            @foreach ($players->groupBy('club_name') as $club_name => $group)
                <div class='wrap-title'>
                    <h4>{{ $club_name }}</h4>
                </div>
                @foreach ($group as $p)
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
            @endforeach
        </div>
        <div class="pagination">
            {{ $players->links('vendor.pagination.pagination-links') }}
        </div>
    </div>
</div>
<!-- end players -->

@endsection

@section('scriptSection')
<script>
    $(document).ready(function() {
        $('#teamFilter').change(function() {
            let selectedTeam = $('#teamFilter').val();
            $.ajax({
                type: 'GET',
                url: '{{ route('user#playerPage') }}',
                data: {
                    'team': selectedTeam,
                },
                dataType: 'json',
                success: function(response) {
                    $('.player-container').empty();
                    $.each(response.players.data, function(index, player) {
                        let teamSection = $('.player-container').find('div.wrap-title:contains("' + player.club_name + '")');
                        
                        if (teamSection.length === 0) {
                            $('.player-container').append(`
                                <div class='wrap-title'>
                                    <h4>${player.club_name}</h4>
                                </div>
                            `);
                        }

                        $('.player-container').append(`
                            <div class='row'>
                                <div class='col s3'>
                                    <div class='content-image'>
                                        <img src='${player.player_photo_url}' alt='${player.name}'>
                                    </div>
                                </div>
                                <div class='col s9'>
                                    <div class='content-text'>
                                        <a href='${player.detail_url}'>
                                            <h6>${player.name}</h6>
                                        </a>
                                        <p></p>
                                        <a href='${player.club_detail_url}'>
                                            <img alt="${player.club_name}" src='${player.club_photo_url}' style='width: 18px; height: 18px;'>
                                            <span>${player.club_name}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                }
            });
        });
    });
</script>
@endsection
