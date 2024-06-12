@extends('users.layouts.master')

@section('title','Register')

@section('content')
    <!-- sign up -->
	<div class="sign-up segments-page">
		<div class="container">
			<div class="signup-contents">
				<h4>Sign Up</h4>
				<form action='{{ route('userRegister') }}' method='post' enctype='multipart/form-data'>
					@csrf
                    <div class="form-group">
                        <label for="">User Name</label>
                        @error('name')
                            <div class="invalid-feedback">
                                <p style="color: red">{{ $message }}</p>
                            </div>
                        @enderror
                        <input type="text" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter User Name..." name="name">
                    </div>
                    <div class="form-group">
                        <label for="">Email Address</label>
                        @error('email')
                            <div class="invalid-feedback">
                                <p style="color: red">{{ $message }}</p>
                            </div>
                        @enderror
    					<input type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email..." name="email">
                    </div>
                    <div class="form-group">
                        <label for="">Profile Photo</label>
    					<input type="file" id="photo" name="photo" accept=".png, .jpg"><br>
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        @error('password')
                            <div class="invalid-feedback">
                                <p style="color: red">{{ $message }}</p>
                            </div>
                        @enderror
    					<input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="">Confirm Password</label>
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                <p style="color: red">{{ $message }}</p>
                            </div>
                        @enderror
    					<input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Retype Password" name="password_confirmation">
                    </div>
					<button class="button"><i class="fa fa-send"></i>Sign Up</button>
				</form>

                <div class="register-link my-3">
                    <p>
                        Already have account?
                        <a href="{{ route('auth#loginPage') }}">Sign In</a>
                    </p>
                </div>
			</div>
		</div>
	</div>
	<!-- end sign up -->
@endsection
