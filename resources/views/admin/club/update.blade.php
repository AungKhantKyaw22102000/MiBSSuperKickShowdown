@extends('admin.layout.master')

@section('title', 'Create Club')

@section('content')
    <!-- standing -->
    <div class="standing segments-page">
        <div class="container"><br>
            <center>
                <h3>Update Club</h3>
            </center>
            <div class="row">
                <div class="col-3 offset-8">
                    <span onclick="history.back()"><i class="fa-solid fa-backward text-dark"></i> Back</span>
                </div>
            </div>
            <form action="{{ route('admin#clubUpdate') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="hidden" name="clubId" value={{ $club->id }}>
                    <label>Team Name</label>
                    @error('clubNname')
                        <div class="invalid-feedback">
                            <p style="color: red">{{ $message }}</p>
                        </div>
                    @enderror
                    <input class="form-control @error('clubName') is-invalid @enderror" type="text" name="clubName" value="{{ $club->name }}">
                </div>
                <div class="form-group">
                    <label>Team Photo</label>
                    @error('clubPhoto')
                        <div class="invalid-feedback">
                            <p style="color: red">{{ $message }}</p>
                        </div>
                    @enderror
                    <input class="form-control @error('clubPhoto') is-invalid @enderror" type="file" name="clubPhoto"">
                </div>
                <div class="form-group">
                    <label>Play Match</label>
                    @error('playedMatch')
                        <div class="invalid-feedback">
                            <p style="color: red">{{ $message }}</p>
                        </div>
                    @enderror
                    <input class="form-control @error('playedMatch') is-invalid @enderror" type="number" name="playedMatch" value="{{ $club->played_match }}" min="0">
                </div>
                <div class="form-group">
                    <label>Win</label>
                    @error('winMatch')
                        <div class="invalid-feedback">
                            <p style="color: red">{{ $message }}</p>
                        </div>
                    @enderror
                    <input class="form-control @error('winMatch') is-invalid @enderror" type="number" name="winMatch" value="{{ $club->win }}" min="0">
                </div>
                <div class="form-group">
                    <label>Draw</label>
                    @error('drawMatch')
                        <div class="invalid-feedback">
                            <p style="color: red">{{ $message }}</p>
                        </div>
                    @enderror
                    <input class="form-control @error('drawMatch') is-invalid @enderror" type="number" name="drawMatch" value="{{ $club->draw }}" min="0">
                </div>
                <div class="form-group">
                    <label>Lose</label>
                    @error('loseMatch')
                        <div class="invalid-feedback">
                            <p style="color: red">{{ $message }}</p>
                        </div>
                    @enderror
                    <input class="form-control @error('lostMatch') is-invalid @enderror" type="number" name="loseMatch" value="{{ $club->lose }}" min="0">
                </div>
                <div class="form-group">
                    <label>GF</label>
                    @error('goalFor')
                        <div class="invalid-feedback">
                            <p style="color: red">{{ $message }}</p>
                        </div>
                    @enderror
                    <input class="form-control @error('goalFor') is-invalid @enderror" type="number" name="goalFor" value="{{ $club->goal_for }}">
                </div>
                <div class="form-group">
                    <label>GA</label>
                    @error('goalAgainst')
                        <div class="invalid-feedback">
                            <p style="color: red">{{ $message }}</p>
                        </div>
                    @enderror
                    <input class="form-control @error('goalAgainst') is-invalid @enderror" type="number" name="goalAgainst" value="{{ $club->goal_against }}">
                </div>
                <div class="form-group">
                    <label>Points</label>
                    @error('point')
                        <div class="invalid-feedback">
                            <p style="color: red">{{ $message }}</p>
                        </div>
                    @enderror
                    <input class="form-control  @error('point') is-invalid @enderror" type="number" name="point" value="{{ $club->points }}">
                </div>
                <button class="btn number-white bg-success" type="submit"><i class="fa-solid fa-pen-nib"></i>Update Club</button>
            </form>
        </div>
    </div>
    <!-- end standing -->
@endsection
