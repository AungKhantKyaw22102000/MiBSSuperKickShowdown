@extends('admin.layout.master')

@section('title', 'Admin Gallery Detail')

@section('content')
    <!-- gallery details -->
    <div class='gallery-details segments-page'>
        <div class='container'>
            <div class="row">
                <div class="col-3 offset-8">
                    <span onclick="history.back()"><i class="fa-solid fa-backward text-dark"></i> Back</span>
                </div>
            </div>
            <div class='wrap-content'>
                <img src='{{ asset('storage/galleryPhoto/' . $gallery->first_photo) }}' alt='{{ $gallery->header }}'>
                <h4>{{ $gallery->header }}</h4>
                <span>{{ $gallery->created_at->format('d-M-Y') }}</span>
                <p>{{ $gallery->briefing }}</p>
                <p>{{ $gallery->main_text }}</p>
                <div class='row'>
                    <div class='col s6'>
                        <div class='content-image'>
                            <img src='{{ asset('storage/galleryPhoto/' . $gallery->second_photo) }}'
                                alt='{{ $gallery->header }}'>
                        </div>
                    </div>
                    <div class='col s6'>
                        <div class='content-image'>
                            <img src='{{ asset('storage/galleryPhoto/' . $gallery->third_photo) }}'
                                alt='{{ $gallery->header }}'>
                        </div>
                    </div>
                </div>
            </div>

            <div class='comments-section'>
                <h4>Comments</h4>

                <div class='author'>
                    <div class='content-image'>
                        <img src='users/" . $commentRow['photo_path'] . "' alt='User Photo'>
                    </div>
                    <div class='content-text'>
                        <h5>" . $commentRow['username'] . "</h5>
                        <p>" . $commentRow['comment_text'] . "</p>
                        <ul>
                            <li>" . $commentRow['formatted_date'] . "</li>
                        </ul>
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
    </div>
    <!-- end gallery details -->
@endsection
