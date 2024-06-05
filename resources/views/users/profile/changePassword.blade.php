@extends('admin.layout.master')

@section('title', 'Admin Change Password')

@section('content')
<!-- start settings -->
<div class="settings segments-page">
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="wrap-content plus-pb">
                    <div class="wrap-title">
                        <h5>Change Password</h5>
                    </div>
                    <div class="content">
                        <form action="{{ route('user#changePassword') }}" method="post">
                            @csrf
                            <div class="form-control">
                                <label for="oldPassword">Old Password</label>
                                @error('oldPassword')
                                    <div class="invalid-feedback">
                                        <p style="color: red">{{ $message }}</p>
                                    </div>
                                @enderror
                                @if (session('notMatch'))
                                    <div class="invalid-feedback">
                                        <p style="color: red">{{ session('notMatch') }}</p>
                                    </div>
                                @endif
                                <input type="password" name="oldPassword" class="form-control @if(session('notMatch')) is-invalid @endif @error('oldPassword') is-invalid @enderror" id="oldPassword">
                            </div>
                            <div class="form-control">
                                <label for="newPassword">New Password</label>
                                @error('newPassword')
                                    <div class="invalid-feedback">
                                        <p style="color: red">{{ $message }}</p>
                                    </div>
                                @enderror
                                <input type="password" name="newPassword" class="form-control @error('newPassword') is-invalid @enderror" id="newPassword">
                            </div>
                            <div class="form-control">
                                <label for="confirmPassword">Confirm Password</label>
                                @error('confirmPassword')
                                    <div class="invalid-feedback">
                                        <p style="color: red">{{ $message }}</p>
                                    </div>
                                @enderror
                                <input type="password" name="confirmPassword" class="form-control @error('confirmPassword') is-invalid @enderror" id="confirmPassword">
                            </div>
                            <button type="submit" class="button">Save Change</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end settings -->
@endsection
