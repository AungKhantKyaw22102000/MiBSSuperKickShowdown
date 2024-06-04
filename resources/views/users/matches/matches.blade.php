@extends('users.layouts.master')

@section('title', 'Match Schedule')

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

<style>
    .progress-bar-team1 {
        background-color: #2196F3 !important; /* Blue for team1 */
    }

    .progress-bar-team2 {
        background-color: #FF9800 !important; /* Orange for team2 */
    }

    .progress-bar-draw {
        background-color: #FFEB3B !important; /* Yellow for draw */
    }

    .progress-bar {
        height: 20px;
        background-color: #ddd;
        margin-bottom: 10px;
        position: relative;
    }
</style>
    <!-- matches -->
    <div class='matches segments-page'>
        <div class='container'>

            @foreach ($matches as $m)
            <div class="wrap-title">
                <h4>{{ $m->play_date }}</h4>
            </div>
            <div class='wrap-content'>
                <div class='row'>
                    <div class='col s8'>
                        <div class='content-left'>
                            <ul>
                                <li>
                                    <a href='{{ route('user#clubDetail', $m->team1_id) }}'>
                                        <img src='{{ asset('storage/clubPhoto/' . $m->team1_photo) }}' style='width: 18px; height: 18px;'>
                                        <span>{{ $m->team1_name }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href='{{ route('user#clubDetail', $m->team2_id) }}'>
                                        <img src='{{ asset('storage/clubPhoto/' . $m->team2_photo) }}' style='width: 18px; height: 18px;'>
                                        <span>{{ $m->team2_name }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class='col s4'>
                        <div class='content-right'>
                            <ul>
                                <li>{{ $m->play_time }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div id='voting-container-{{$m->id}}'>
                <div class='wrap-content'>
                    <form action='{{ route('user#createVote') }}' method='post' id='vote-form-{{$m->id}}'>
                        @csrf 
                        <input type='hidden' name='match_id' value='{{$m->id}}'>
                        <button type='button' onclick="submitVote('team1', {{$m->id}}, 'team1')">{{ $m->team1_name }}</button>
                        <button type='button' onclick="submitVote('team2', {{$m->id}}, 'team2')">{{ $m->team2_name }}</button>
                        <button type='button' onclick="submitVote('draw', {{$m->id}}, 'draw')">Draw</button>
                    </form>
                </div>
            </div>

            <div id='result-container-{{$m->id}}' style='display: none;'>
                <div class='wrap-content'>
                    <div class='progress-bar' id='progress-bar-{{$m->id}}'></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- end matches -->
@endsection

@section('scriptSection')
<script>
    function submitVote(selectedOption, matchId, option) {
        var form = document.getElementById('vote-form-' + matchId);
        var progressBar = document.getElementById('progress-bar-' + matchId);

        var formData = new FormData(form);
        formData.set('vote', selectedOption); // Set the selectedOption as the 'vote' value

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route('user#createVote') }}', true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                document.getElementById('voting-container-' + matchId).style.display = 'none';
                document.getElementById('result-container-' + matchId).style.display = 'block';

                var resultContainer = document.getElementById('result-container-' + matchId);
                resultContainer.innerHTML = xhr.responseText;

                // Use option argument to set background color
                if (option === 'team1') {
                    progressBar.style.backgroundColor = '#2196F3'; // Blue for team1
                } else if (option === 'team2') {
                    progressBar.style.backgroundColor = '#FF9800'; // Orange for team2
                } else if (option === 'draw') {
                    progressBar.style.backgroundColor = '#FFEB3B'; // Yellow for draw
                }
            } else {
                console.error('Error submitting vote: ' + xhr.statusText);
            }
        };

        xhr.send(formData);
    }
</script>

@guest
    <script>
        $(document).ready(function(){
            $('.vote-button').click(function(){
                event.preventDefault();
                window.location.href = "{{ route('auth#loginPage') }}";
            })
        })
    </script>
@endguest

@endsection
