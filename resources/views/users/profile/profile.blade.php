@extends('users.layouts.master')

@section('title','User Profile')

@section('content')
    <!-- start settings -->
    <div class="settings segments-page">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div class="wrap-content plus-pb">
                        <div class="wrap-title">
                            <h5>Profile</h5>
                        </div>
                        <div class="content">
                            <form method='post' action="{{ route('user#updateProfile', Auth::user()->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-control">
                                    @if (Auth::user()->image == null)
                                        <img src="{{ asset('image/default_user.jpg') }}" alt="User Photo" class="img-thumbnail">
                                    @else
                                        <img src="{{ asset('storage/userPhoto/' . Auth::user()->image) }}" class="img-thumbnail" alt="">
                                    @endif
                                </div>
                                <br><br><br><br><br>
                                <div class="form-control">
                                    <label>User Name</label>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', Auth::user()->name) }}">
                                </div>
                                <div class="form-control">
                                    <label>User Email</label>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', Auth::user()->email) }}" readonly>
                                </div>
                                <div class="form-control">
                                    <label>User Photo</label>
                                    @error('userPhoto')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <input type="file" name="userPhoto" class="form-control @error('userPhoto') is-invalid @enderror">
                                </div>
                                <button type="submit" class="button">Save Change</button>
                            </form>

                            <div class="register-link my-3">
                                <p>
                                    Do You Want to Change Your Password?
                                    <a href="{{ route('user#changePasswordPage') }}">Click Here</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end settings -->

@endsection
