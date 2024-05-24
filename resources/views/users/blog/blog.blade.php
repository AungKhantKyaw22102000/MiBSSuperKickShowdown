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


                <div class='col s6 content'>
                    <a href='gallery/' data-lightbox='gallery'>
                        <img src='gallery/' alt=''>
                    </a>
                    <a href='gallery-details.php?viewgallery=" . $id . "'>
                        <h6></h6>
                    </a>
                    <a href='gallery-details.php?viewgallery=" . $id . "'>
                        <span></span>
                    </a><br>
                    <span class='formatted-date'>

                    </span><br>
                </div>
            </div>
        </div>
        <!-- end gallery -->
@endsection
