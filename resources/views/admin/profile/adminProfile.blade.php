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
                            <form method='POST' action="admin/update_profile.php" enctype="multipart/form-data">
                                <div class="form-control">
                                    <img src="{{ asset('image/default_user.jpg') }}" alt="User Photo">
                                </div><br><br><br><br><br>
                                <div class="form-control">
                                    <label>User Name</label>
                                    <input type="text" name="username" value="{{ Auth::user()->name }}">
                                </div>
                                <div class="form-control">
                                    <label>User Email</label>
                                    <input type="email" name="email" value="{{ Auth::user()->email }}" readonly>
                                </div>
                                <div class="form-control">
                                    <label>User Role</label>
                                    <input type="email" name="text" value="{{ Auth::user()->role }}" readonly>
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
