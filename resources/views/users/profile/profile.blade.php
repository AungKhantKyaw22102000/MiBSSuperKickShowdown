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
							<h5>Photo Profile</h5>
						</div>
						<div class="content">
							<form method='POST' action="admin/update_profile.php" enctype="multipart/form-data">
								<img src="users/" alt="User Photo">
								<div class="button-upload">
									<input id="button-file" type="file" name='photo'>
									<label for="button-file">
										<span class="button">Upload</span>
									</label>
								</div><br><br>
								<input type="text" name="username" value="" required>
								<input type="email" name="email" value="" required readonly>
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
