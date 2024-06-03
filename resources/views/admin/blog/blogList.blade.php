@extends('admin.layout.master')

@section('title', 'Gallery Page')

@section('search')
<!-- search -->
<div id="modal1" class="modal">
    <div class="modal-content">
        <form id="player-search-form" method="get">
            @csrf
            <input type="text" name="key" value="{{ request('key') }}" id="search-input" placeholder="Search">
            <button class="button" id="search-button">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>
<!-- end search -->
@endsection

@section('content')
    <!-- standing -->
    <div class="standing segments-page">
        <div class="container"><br>
            <div class="button-container ">
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('admin#galleryCreatePage') }}" class="custom-button" style="--clr:#BC13FE"><span class="d-block">Add Blog</span><i></i></a>
                    </div>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Gallery ID</th>
                        <th>Header</th>
                        <th>Sub Header</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($galleries as $g)
                    <tr class='$rowClass'>
                        <td>
                            {{ $g->id }}
                        </td>
                        <td><a href="{{ route('admin#galleryDetail', $g->id) }}">{{ $g->header }}</a></td>
                        <td>{{ $g->sub_header }}</td>
                        <td>
                            <div class='btn-group'>
                                <a class='' href='{{ route('admin#galleryUpdatePage', $g->id) }}'>
                                    <i class='fa-solid fa-pen-to-square' title='Update'></i>
                                </a>
                                <a class='' href='{{ route('admin#deleteGallery', $g->id) }}'>
                                    <i class='fa-solid fa-trash-can' title='Delete'></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- end standing -->
@endsection
