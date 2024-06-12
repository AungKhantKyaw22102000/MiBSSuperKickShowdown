@extends('users.layouts.master')

@section('title', 'Forgot Password')

@section('content')
<!-- sign in -->
<div class="sign-in segments-page">
    <div class="container">
        <div class="signin-contents">
            <h4>Forgot Password</h4>
            <b>We Will Send a link to your email, use that lik to reset pasword!</b><br>
            <form action="{{ route('auth#forgotPassword') }}" method="POST">
                @csrf
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
                    <label>Email</label>
                    <input type="email" name='email' value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                </div>
                <button class="button" type='submit'><i class="fa fa-send"></i>Send</button>
            </form>
        </div>
    </div>
</div>
<!-- end sign in -->
@endsection
