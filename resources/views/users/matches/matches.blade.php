@extends('users.layouts.master')

@section('title', 'Match Schedule')
<meta name="csrf-token" content="{{ csrf_token() }}">

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
        .progress-bar {
            height: 20px;
            background-color: #ddd;
            margin-bottom: 10px;
            position: relative;
        }

        .progress-bar-team1 {
            background-color: #2196F3 !important;
            /* Blue for team1 */
        }

        .progress-bar-draw {
            background-color: #FFEB3B !important;
            /* Yellow for draw */
        }

        .progress-bar-team2 {
            background-color: #FF9800 !important;
            /* Orange for team2 */
        }

        .progress-bar>div {
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }
    </style>

    <!-- matches -->
    <div class='matches segments-page'>
        <div class='container'>

            @foreach ($groupedMatches as $date => $matches)
                <div class="wrap-title">
                    <h4>{{ \Carbon\Carbon::parse($date)->format('M-d-Y') }}</h4>
                </div>

                @foreach ($matches as $m)
                    <div class='wrap-content' id='match-container-{{ $m->id }}'>
                        <div class='row'>
                            <div class='col s8'>
                                <div class='content-left'>
                                    <ul>
                                        <li>
                                            <a href='{{ route('user#clubDetail', $m->team1_id) }}'>
                                                <img src='{{ asset('storage/clubPhoto/' . $m->team1_photo) }}'
                                                    style='width: 18px; height: 18px;'>
                                                <span class="team1-name">{{ $m->team1_name }}</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href='{{ route('user#clubDetail', $m->team2_id) }}'>
                                                <img src='{{ asset('storage/clubPhoto/' . $m->team2_photo) }}'
                                                    style='width: 18px; height: 18px;'>
                                                <span class="team2-name">{{ $m->team2_name }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class='col s4'>
                                <div class='content-right'>
                                    <ul>
                                        <li>{{ \Carbon\Carbon::parse($m->play_time)->format('g:i A') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id='voting-container'>
                        <div class='wrap-content'>
                            <form action='{{ route('user#createVote') }}' method='post' id='vote-form'>
                                @csrf
                                <input type='hidden' name='matchId' class="matchId" value='{{ $m->id }}'>
                                @auth
                                    <input type="hidden" name="userId" value="{{ Auth::user()->id }}">
                                @endauth
                                <button type='button' class="vote-button1" value="team1">{{ $m->team1_name }}</button>
                                <button type='button' class="vote-button2" value="draw">Draw</button>
                                <button type='button' class="vote-button3" value="team2">{{ $m->team2_name }}</button>
                            </form>
                        </div>
                    </div>

                    <div id='result-container-{{ $m->id }}' style='display: none;'>
                        <div class='wrap-content'>
                            <div class='progress-bar' id='progress-bar-team1-{{ $m->id }}'></div>
                            <div class='progress-bar' id='progress-bar-draw-{{ $m->id }}'></div>
                            <div class='progress-bar' id='progress-bar-team2-{{ $m->id }}'></div>
                        </div>
                    </div>
                @endforeach
            @endforeach

        </div>
    </div>
    <!-- end matches -->
@endsection

@section('scriptSection')
<script>
    $(document).ready(function() {
        $('.vote-button1, .vote-button2, .vote-button3').click(function() {
            var vote = $(this).val();
            var parentNode = $(this).closest('.wrap-content');
            var matchId = parentNode.find('.matchId').val();
            var team1Name = parentNode.find('.team1-name').text();
            var team2Name = parentNode.find('.team2-name').text();
            @auth
                @if(Auth::user()->email_verified_at === null)
                    alert('You need to verify your email before voting. Check your email inbox for the verification email.');
                    return;
                @endif
            @endauth

            if (['team1', 'team2', 'draw'].includes(vote)) {
                var data = {
                    'matchId': matchId,
                    'vote': vote
                };
                $.ajax({
                    type: 'post',
                    url: '{{ route('user#createVote') }}',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        console.log(response); // Log the entire response for debugging
                        showProgressBar(response, matchId, team1Name, team2Name); // Pass team names to showProgressBar function
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 403) {
                            alert('You have already voted for this match today.');
                        } else {
                            console.error('Error submitting vote:', error);
                            console.log(xhr.responseText);
                        }
                    }
                });
            } else {
                console.error('Invalid vote selected');
            }
        });

        function showProgressBar(response, matchId, team1Name, team2Name) {
            console.log('Team 1 Name:', team1Name);
            console.log('Team 2 Name:', team2Name);
            var totalVotes = response.total;
            var team1Votes = response.team1;
            var team2Votes = response.team2;
            var drawVotes = response.draw;

            // Calculate percentages for each option
            var team1Percentage = (team1Votes / totalVotes * 100);
            var drawPercentage = (drawVotes / totalVotes * 100);
            var team2Percentage = (team2Votes / totalVotes * 100);

            // Update progress bars for the specific match with correct team names
            $('#progress-bar-team1-' + matchId).css('width', team1Percentage + '%').text('Upper Team');
            $('#progress-bar-draw-' + matchId).css('width', drawPercentage + '%').text('Draw');
            $('#progress-bar-team2-' + matchId).css('width', team2Percentage + '%').text('Lower Team');

            $('#result-container-' + matchId).show(); // Show the result container for this match
        }
    });
</script>

    @guest
        <script>
            $(document).ready(function() {
                $('.vote-button1, .vote-button2, .vote-button3').click(function() {
                    event.preventDefault();
                    window.location.href = "{{ route('auth#loginPage') }}";
                })
            })
        </script>
    @endguest

@endsection
