@extends('users.layouts.master')

@section('title', 'Forgot Password')

@section('content')
<!-- sign in -->
<div class="sign-in segments-page">
    <div class="container">
        <div class="signin-contents">
            <h4>Forgot Password</h4>
            <p>We Will Send a link to your email, use that lik to reset pasword!</p>
            <form action="{{ route('auth#resetPasswordPost') }}" method="POST">
                @csrf
                <input type="hidden" value="{{ $token }}" name="token">
                <div class="form-group">
                    @error('email')
                        <div class="invalid-feedback">
                            <p style="color: red">{{ $message }}</p>
                        </div>
                    @enderror
                    @if(session()->has('success'))
                        <div class="invalid-feedback">
                            <p style="color: green">{{ session('success') }}</p>
                        </div>
                    @endif
                    @if(session()->has('error'))
                        <div class="invalid-feedback">
                            <p style="color: red">{{ session('error') }}</p>
                        </div>
                    @endif
                    <input type="email" name='email' value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                </div>
                <div class="form-group">
                    @error('password')
                        <div class="invalid-feedback">
                            <p style="color: red">{{ $message }}</p>
                        </div>
                    @enderror
                    <input type="password" name='password' class="form-control @error('password') is-invalid @enderror" placeholder="password">
                </div>
                <div class="form-group">
                    @error('password_confirmation')
                        <div class="invalid-feedback">
                            <p style="color: red">{{ $message }}</p>
                        </div>
                    @enderror
                    <input type="password" name='password_confirmation' class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password">
                </div>
                <button class="button" type='submit'><i class="fa fa-send"></i>Submit</button>
            </form>
        </div>
    </div>
</div>
<!-- end sign in -->
@endsection
