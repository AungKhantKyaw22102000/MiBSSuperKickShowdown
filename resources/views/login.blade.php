@extends('users.layouts.master')

@section('title','Sign In')

@section('content')
    <!-- sign in -->
	<div class="sign-in segments-page">
		<div class="container">
			<div class="signin-contents">
				<h4>Sign In</h4>
				<form action="admin/signin.php" method="POST">
					<input type="email" name='email' placeholder="Email" required>
					<input type="password" name='pw' placeholder="Password" required>
					<button class="button" type='submit'><i class="fa fa-send"></i>Sign in</button>
				</form>
			</div>
		</div>
	</div>
	<!-- end sign in -->
@endsection
