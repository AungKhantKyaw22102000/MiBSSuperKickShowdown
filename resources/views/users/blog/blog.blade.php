@extends('users.layouts.master')

@section('title', 'Blog')

@section('content')
    <!-- gallery -->
    <div class='gallery segments-page'>
        <div class='container'>
            <div class='wrap-title'>
                <h3>Gallery</h3>
            </div>
            <div class='row'>
                <div class="wrap-filter">
                    <h6>Filter By Date</h6><br>
                    <select class="browser-default" id="dateFilter">
                        <option value="all">All Dates</option>
                    </select>
                </div><br>


                @foreach ($galleries as $gallery)
                <div class='col s6 content'>
                    <a href='{{ asset('storage/galleryPhoto/' . $gallery->first_photo) }}' data-lightbox='gallery'>
                        <img src='{{ asset('storage/galleryPhoto/' . $gallery->first_photo) }}' alt='{{ $gallery->header }}'>
                    </a>
                    <a href='{{ route('user#blogDetail', $gallery->id) }}'>
                        <h6>{{ $gallery->header }}</h6>
                    </a>
                    <a href='{{ route('user#blogDetail', $gallery->id) }}'>
                        <span>{{ $gallery->sub_header }}</span>
                    </a><br>
                    <span class='formatted-date'>
                        {{ $gallery->created_at->format('d-M-Y') }}
                    </span><br>
                </div>
                @endforeach
            </div>
        </div>
        <!-- end gallery -->
@endsection
