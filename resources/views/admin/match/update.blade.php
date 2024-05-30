@extends('admin.layout.master')

@section('title', 'Update Match')

@section('content')
<!-- standing -->
<div class="standing segments-page">
    <div class="container"><br>
        <center>
            <h3>Update Match</h3>
        </center>
        <div class="row">
            <div class="col-3 offset-8">
                <span onclick="history.back()"><i class="fa-solid fa-backward text-dark"></i> Back</span>
            </div>
        </div>
        <form action="{{ route('admin#footballMatchUpdate') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Play Date</label>
                @error('playDate')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <input type="hidden" name="matchId" value="{{ $match->id }}">
                <input class="form-control @error('playDate') is-invalid @enderror" type="date" value="{{ old("playDate", $match->play_date) }}" name="playDate">
            </div>
            <div class="form-group">
                <label>First Team</label>
                @error('firstTeam')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <select name="firstTeam" class="form-control @error('firstTeam') is-invalid @enderror" id="">
                    <option value="">Choose Club</option>
                    @foreach ($club as $c)
                        <option value="{{ $c->id }}" @if($match->team1_id == $c->id) selected @endif>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>First Team Goal</label>
                @error('firstTeamGoal')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <input class="form-control @error('firstTeamGoal') is-invalid @enderror" type="number" name="firstTeamGoal" value="{{ old('firstTeamGoal', $match->team1_goal)}}">
            </div>
            <div class="form-group">
                <label>First Team Yellow Card</label>
                @error('firstTeamYellowCard')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <input class="form-control @error('firstTeamYellowCard') is-invalid @enderror" type="number" name="firstTeamYellowCard" value="{{ old('firstTeamYellowCard', $match->team1_yellow_card)}}">
            </div>
            <div class="form-group">
                <label>First Team Red Card</label>
                @error('firstTeamRedCard')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <input class="form-control @error('firstTeamRedCard') is-invalid @enderror" type="number" name="firstTeamRedCard" value="{{ old('firstTeamRedCard', $match->team1_red_card)}}">
            </div>
            <div class="form-group">
                <label>Second Team</label>
                @error('secondTeam')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <select name="secondTeam" class="form-control @error('secondTeam') is-invalid @enderror" id="">
                    <option value="">Choose Club</option>
                    @foreach ($club as $c)
                        <option value="{{ $c->id }}" @if($match->team2_id == $c->id) selected @endif>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Second Team Goal</label>
                @error('secondTeamGoal')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <input class="form-control @error('secondTeamGoal') is-invalid @enderror" type="number" name="secondTeamGoal" value="{{ old('secondTeamGoal', $match->team2_goal)}}">
            </div>
            <div class="form-group">
                <label>Second Team Yellow Card</label>
                @error('secondTeamYellowCard')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <input class="form-control @error('secondTeamYellowCard') is-invalid @enderror" type="number" name="secondTeamYellowCard" value="{{ old('secondTeamYellowCard', $match->team2_yellow_card)}}">
            </div>
            <div class="form-group">
                <label>Second Team Red Card</label>
                @error('secondTeamRedCard')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <input class="form-control @error('secondTeamRedCard') is-invalid @enderror" type="number" name="secondTeamRedCard" value="{{ old('secondTeamRedCard', $match->team2_red_card)}}">
            </div>
            <div class="form-group">
                <label>Play Time</label>
                @error('playTime')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <input class="form-control @error('playTime') is-invalid @enderror" type="time" name="playTime" value="{{ old('playTime', $match->play_time)}}">
            </div>
            <div class="form-gorup">
                <label>Match is finished</label>
                <input type="hidden" name="finished" value="0" style="margin: -10px 0 0 12px;">
                <input type="checkbox" name="finished" value="1" {{ $match->finished == 1 ? 'checked' : '' }} style="margin: -10px 0 0 12px;">
            </div><br>
            <button class="btn number-white bg-success" type="submit"><i class="fa-solid fa-plus btn-sm"></i>Update Match</button>
        </form>
    </div>
</div>
<!-- end standing -->
@endsection
