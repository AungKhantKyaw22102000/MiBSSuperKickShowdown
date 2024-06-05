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
                    @foreach ($paginatedGalleries as $date => $group)
                        <option value="{{ Carbon\Carbon::parse($date)->format('Y-m-d') }}" @if(request('date') == Carbon\Carbon::parse($date)->format('Y-m-d')) selected @endif>
                            {{ $date }}
                        </option>
                    @endforeach
                </select>
            </div><br>
            <div id="gallery-content">
                @foreach ($paginatedGalleries as $date => $group)
                    <div class='wrap-title'>
                        <h4>{{ $date }}</h4>
                    </div>
                    @foreach ($group as $gallery)
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
                @endforeach
            </div>
        </div>
        <div class="pagination">
            {{ $paginatedGalleries->links('vendor.pagination.pagination-links') }}
        </div>
    </div>
</div>
<!-- end gallery -->
@endsection

@section('scriptSection')
<script>
    $(document).ready(function() {
        $('#dateFilter').change(function() {
            let selectedDate = $('#dateFilter').val();
            $.ajax({
                type: 'GET',
                url: '{{ route('user#blogPage') }}',
                data: {
                    'date': selectedDate,
                },
                dataType: 'json',
                success: function(response) {
                    $('#gallery-content').empty();
                    $.each(response.galleries, function(date, group) {
                        let dateTitle = `<div class='wrap-title'><h4>${date}</h4></div>`;
                        $('#gallery-content').append(dateTitle);

                        $.each(group, function(index, gallery) {
                            let galleryItem = `
                                <div class='col s6 content'>
                                    <a href='${gallery.first_photo_url}' data-lightbox='gallery'>
                                        <img src='${gallery.first_photo_url}' alt='${gallery.header}'>
                                    </a>
                                    <a href='${gallery.detail_url}'>
                                        <h6>${gallery.header}</h6>
                                    </a>
                                    <a href='${gallery.detail_url}'>
                                        <span>${gallery.sub_header}</span>
                                    </a><br>
                                    <span class='formatted-date'>
                                        ${gallery.created_at}
                                    </span><br>
                                </div>
                            `;
                            $('#gallery-content').append(galleryItem);
                        });
                    });
                }
            });
        });
    });
</script>
@endsection
