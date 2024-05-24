@extends('users.layouts.master')

@section('title','Register')

@section('content')
    <!-- sign up -->
	<div class="sign-up segments-page">
		<div class="container">
			<div class="signup-contents">
				<h4>Sign Up</h4>
				<form action='admin/insert_user.php' method='post' enctype='multipart/form-data'>
					<input type="text" placeholder="Username" name="username">
					<input type="email" placeholder="Email" name="email">
					<input type="file" id="photo" name="photo" accept=".png, .jpg"><br>
					<input type="password" placeholder="Password" name="password">
					<input type="password" placeholder="Retype Password" name="retype_password">
					<button class="button"><i class="fa fa-send"></i>Sign Up</button>
				</form>
			</div>
		</div>
	</div>
	<!-- end sign up -->
@endsection
