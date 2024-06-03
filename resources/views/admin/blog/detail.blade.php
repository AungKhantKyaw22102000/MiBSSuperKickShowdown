@extends('admin.layout.master')

@section('title', 'Admin Gallery Detail')

@section('content')
    <!-- gallery details -->
    <div class='gallery-details segments-page'>
        <div class='container'>
            <div class="row">
                <div class="col-3 offset-8">
                    <a href="{{ route('admin#galleryList') }}"><span><i class="fa-solid fa-backward text-dark"></i> Back</span></a>
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

                @foreach ($comments as $comment)
                <div class='author'>
                    <div class='content-image'>
                        @if ($comment->user_image == null)
                            <img src="{{ asset('image/default_user.jpg') }}" alt="User Photo">
                        @else
                            <img src="{{ asset('storage/userPhoto/' . $comment->user_image) }}" class="img-thumbnail" alt="{{ $comment->user_name }}">
                        @endif
                    </div>
                    <div class='content-text'>
                        <h5>{{ $comment->user_name }}</h5>
                        <p>{{ $comment->comment }}</p>
                        <ul>
                            <li>{{ $comment->created_at->format('d-M-Y') }}</li>
                        </ul>
                    </div>
                </div>
                @endforeach

                <div class='comment-form'>
                    <h4>Leave Your Reply</h4>
                    <form action='' method='POST'>
                        @csrf
                        <input type='hidden' name='galleryId' value='{{ $gallery->id }}'>
                        <input type="hidden" name="userId" value="{{ Auth::user()->id }}">
                        <textarea name='commentMessage' cols='30' rows='10' placeholder='Message'></textarea>
                        <button class='button' type='submit'><i class='fa fa-send'></i>Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end gallery details -->
@endsection
