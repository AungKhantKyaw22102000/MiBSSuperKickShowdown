@extends('admin.layout.master')

@section('title', 'Player Page')

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
                        <a href="{{ route('admin#playerCreatePage') }}" class="custom-button" style="--clr:#BC13FE"><span class="d-block">Add Player</span><i></i></a>
                    </div>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Player ID</th>
                        <th>Name</th>
                        <th>Photo</th>
                        <th>Club</th>
                        <th>Back Number</th>
                        <th>Date of Birth</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($players as $p)
                    <tr class='$rowClass'>
                        <td>{{ $p->id }}</td>
                        <td>
                            <a href="{{ route('admin#playerDetail', $p->id) }}">
                                {{ $p->name }}
                            </a>
                        </td>
                        <td>
                            <img src="{{ asset('storage/playerPhoto/'.$p->player_photo) }}" style="width: 100px; height: 100px;" class=" img-thumbnail" alt="{{ $p->name }}">
                        </td>
                        <td>{{ $p->club_name }}</td>
                        <td>{{ $p->back_number}}</td>
                        <td>{{ $p->date_of_birth }}</td>
                        <td>
                            <div class='btn-group'>
                                <a class='' href='{{ route('admin#playerUpdatePage', $p->id) }}'>
                                    <i class='fa-solid fa-pen-to-square' title='Update'></i>
                                </a>
                                <a class='' href='{{ route('admin#playerDelete', $p->id) }}'>
                                    <i class='fa-solid fa-trash-can' title='Delete'></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination">
                {{ $players->links('vendor.pagination.pagination-links') }}
            </div>
        </div>
    </div>
    <!-- end standing -->
@endsection
