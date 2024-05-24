@extends('users.layouts.master')

@section('title', 'Blog Detail')

@section('content')
    <!-- gallery details -->
    <div class='gallery-details segments-page'>
        <div class='container'>

            <div class='wrap-content'>
                <img src='gallery/' alt=''>
                <h4></h4>
                <span></span>
                <p></p>
                <p></p>
                <div class='row'>
                    <div class='col s6'>
                        <div class='content-image'>
                            <img src='gallery/' alt=''>
                        </div>
                    </div>
                    <div class='col s6'>
                        <div class='content-image'>
                            <img src='gallery/' alt=''>
                        </div>
                    </div>
                </div>
            </div>

            <div class='comments-section'>
                <h4>Comments</h4>
                <div class='author'>
                    <div class='content-image'>
                        <img src='users/' alt='User Photo'>
                    </div>
                    <div class='content-text'>
                        <h5></h5>
                        <p></p>
                        <ul>
                            <li></li>
                        </ul>
                    </div>
                </div>

            </div>

            <div class='comment-form'>
                <h4>Leave Your Reply</h4>
                <form action='admin/insert_comment.php' method='POST'>
                    <!-- Add hidden input for gallery_id -->
                    <input type='hidden' name='gallery_id' value='" . $gid . "'>
                    <textarea name='message' cols='30' rows='10' placeholder='Message'></textarea>
                    <button class='button' type='submit'><i class='fa fa-send'></i>Submit</button>
                </form>
            </div>

        </div>
    </div>
    <!-- end gallery details -->

@endsection
