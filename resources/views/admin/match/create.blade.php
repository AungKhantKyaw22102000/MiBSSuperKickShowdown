@extends('admin.layout.master')

@section('title', 'Create A Match')

@section('content')
    <!-- standing -->
    <div class="standing segments-page">
        <div class="container"><br>
            <center>
                <h3>Create A Match</h3>
            </center>
            <div class="row">
                <div class="col-3 offset-8">
                    <span onclick="history.back()"><i class="fa-solid fa-backward text-dark"></i> Back</span>
                </div>
            </div>
            <form action="{{ route('admin#footballMatchCreate') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Play Date</label>
                    @error('playDate')
                        <div class="invalid-feedback">
                            <p style="color: red">{{ $message }}</p>
                        </div>
                    @enderror
                    <input class="form-control @error('playDate') is-invalid @enderror" type="date" value="{{ old("playDate") }}" name="playDate">
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
                        @foreach ($clubs as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
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
                        @foreach ($clubs as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Play Time</label>
                    @error('playTime')
                        <div class="invalid-feedback">
                            <p style="color: red">{{ $message }}</p>
                        </div>
                    @enderror
                    <input class="form-control @error('playTime') is-invalid @enderror" type="time" name="playTime" value="{{ old('playTime')}}">
                </div>
                <button class="btn number-white bg-success" type="submit"><i class="fa-solid fa-plus btn-sm"></i>Create Match</button>
            </form>
        </div>
    </div>
    <!-- end standing -->
@endsection
