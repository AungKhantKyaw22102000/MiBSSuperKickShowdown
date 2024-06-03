@extends('admin.layout.master')

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
                            <form method='post' action="{{ route('admin#update', Auth::user()->id) }}" enctype="multipart/form-data">
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
                                <div class="form-control">
                                    <label>User Role</label>
                                    @error('role')
                                        <div class="invalid-feedback">
                                            <p style="color: red">{{ $message }}</p>
                                        </div>
                                    @enderror
                                    <input type="text" name="role" class="form-control @error('role') is-invalid @enderror" value="{{ Auth::user()->role }}" disabled>
                                </div>
                                <button type="submit" class="button">Save Change</button>
                            </form>

                            <div class="register-link my-3">
                                <p>
                                    Do You Want to Change Your Password?
                                    <a href="{{ route('admin#changePasswordPage') }}">Click Here</a>
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
