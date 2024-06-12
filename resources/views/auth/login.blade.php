@extends('users.layouts.master')

@section('title', 'Sign In')

@section('content')
    <!-- sign in -->
    <div class="sign-in segments-page">
        <div class="container">
            <div class="signin-contents">
                <h4>Sign In</h4>
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        @error('email')
                            <div class="invalid-feedback">
                                <p style="color: red">{{ $message }}</p>
                            </div>
                        @enderror
                        <input type="email" name='email' value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email">

                    </div>

                    <div class="form-group">
                        @error('password')
                            <div class="invalid-feedback">
                                <p style="color: red">{{ $message }}</p>
                            </div>
                        @enderror
                        <input type="password" name='password' class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                    </div>

                    <button class="button" type='submit'><i class="fa fa-send"></i>Sign in</button>
                </form>

                <div class="register-link my-3">
                    <p>
                        <a href="{{ route('auth#forgotPasswordPage')}}">Forgot Password?</a><br>
                        Don't you have account?
                        <a href="{{ route('auth#registerPage') }}">Sign Up Here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- end sign in -->
@endsection
