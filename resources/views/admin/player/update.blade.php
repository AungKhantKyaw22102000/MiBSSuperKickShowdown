@extends('admin.layout.master')

@section('title', 'Update Admin Player Profile')

@section('content')
<!-- standing -->
<div class="standing segments-page">
    <div class="container"><br>
        <center>
            <h3>Update Player</h3>
        </center>
        <div class="row">
            <div class="col-3 offset-8">
                <span onclick="history.back()"><i class="fa-solid fa-backward text-dark"></i> Back</span>
            </div>
        </div>
        <form action="{{ route('admin#playerCreate') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Name</label>
                @error('playerName')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <input class="form-control @error('playerName') is-invalid @enderror" type="text" name="playerName" value="{{ $players->name }}">
            </div>
            <div class="form-group">
                <label>Back Number</label>
                @error('backNumber')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <input class="form-control @error('backNumber') is-invalid @enderror" type="text" name="backNumber" value="{{ $players->back_number }}">
            </div>
            <div class="form-group">
                <label>Player Photo</label>
                @error('playerPhoto')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <input class="form-control @error('playerPhoto') is-invalid @enderror" type="file" name="playerPhoto">
            </div>
            <div class="form-group">
                <label>Player's Club</label>
                @error('playerClub')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <select name="playerClub" id="" class="form-control @error('playerClub') is-invalid @enderror">
                    <option value="">Choose Club</option>
                    @foreach ($clubs as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-5">
                <label>Goal</label>
                @error('playerGoal')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <input class="form-control @error('playerGoal') is-invalid @enderror" type="number" name="playerGoal" min="0">
            </div>
            <div class="form-group">
                <label>Assist</label>
                @error('playerAssist')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <input class="form-control @error('playerAssist') is-invalid @enderror" type="number" name="playerAssist" min="0">
            </div>
            <div class="form-group">
                <label>Yellow Card</label>
                @error('playerYellowCard')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <input class="form-control @error('playerYellowCard') is-invalid @enderror" type="number" name="playerYellowCard" min="0">
            </div>
            <div class="form-group">
                <label>Red Card</label>
                @error('playerRedCard')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <input class="form-control @error('playerRedCard') is-invalid @enderror" type="number" name="playerRedCard" min="0">
            </div>
            <div class="form-group">
                <label>Date of Birth</label>
                @error('dateOfBirth')
                    <div class="invalid-feedback">
                        <p style="color: red">{{ $message }}</p>
                    </div>
                @enderror
                <input class="form-control @error('dateOfBirth') is-invalid @enderror" type="date" name="dateOfBirth">
            </div>
            <div class="form-group">
                <button class="btn number-white bg-success" type="submit"><i class="fa-solid fa-plus btn-sm"></i>Create Blog</button>
            </div>
        </form>
    </div>
</div>
<!-- end standing -->
@endsection
