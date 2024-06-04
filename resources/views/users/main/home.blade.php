@extends('users.layouts.master')

@section('title', 'Home')

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
    <!-- standing -->
    <div class="standing segments-page">
        <div class="container"><br>
            <div class="button-container">
                <a href="{{ route('user#matchPage') }}" class="custom-button" style="--clr:#BC13FE"><span>Schedule</span><i></i></a>
                <a href="{{ route('user#statsPage') }}" class="custom-button" style="--clr:#FFF01F"><span>Statistics</span><i></i></a>
                <a href="{{ route('user#resultPage') }}" class="custom-button" style="--clr:#39FF14"><span>Result</span><i></i></a>
                <a href="{{ route('user#playerPage') }}" class="custom-button" style="--clr:#FF3131"><span>Player</span><i></i></a>
                <a href="{{ route('user#blogPage') }}" class="custom-button" style="--clr:#EA00FF"><span>Gallery</span><i></i></a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th class="custom-th">Pos</th>
                        <th>Club</th>
                        <th>PL</th>
                        <th>W</th>
                        <th>D</th>
                        <th>L</th>
                        <th>GF</th>
                        <th>GA</th>
                        <th>GD</th>
                        <th>Pts</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                        $totalClubs = count($club);
                    @endphp

                    @foreach ($club as $c)
                        @if ($i <= $totalClubs)
                            <tr class=''>
                                <td>{{ $i }}</td>
                                <td>
                                    <a href="{{ route('user#clubDetail', $c->id) }}">
                                        <img src="{{ asset('storage/clubPhoto/' . $c->club_photo) }}" style='width: 20px; height: 20px;'>
                                        <span>{{ $c->name }}</span>
                                    </a> 
                                </td>
                                <td>{{ $c->played_match }}</td>
                                <td>{{ $c->win }}</td>
                                <td>{{ $c->draw }}</td>
                                <td>{{ $c->lose }}</td>
                                <td>{{ $c->goal_for }}</td>
                                <td>{{ $c->goal_against }}</td>
                                <td>{{ $c->goal_difference }}</td>
                                <td>{{ $c->points }}</td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                        @endif
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    <!-- end standing -->
@endsection
