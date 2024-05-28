@extends('admin.layout.master')

@section('title', 'Club List')

@section('content')
    <!-- standing -->
    <div class="standing segments-page">
        <div class="container"><br>
            <div class="button-container ">
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('admin#clubCreatePage') }}" class="custom-button" style="--clr:#BC13FE"><span class="d-block">Add Club</span><i></i></a>
                    </div>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Club ID</th>
                        <th>Club Name</th>
                        <th>Played Matches</th>
                        <th>Pts</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($club as $c)
                    <tr class='$rowClass'>
                        <td>{{ $c->id }}</td>
                        <td>
                            <a href='{{ route('admin#clubDetail', $c->id) }}'>
                                <img src='{{ asset('storage/clubPhoto/'.$c->club_photo)}}' style='width: 20px; height: 20px;' alt="{{ $c->name }}">{{ $c->name }}
                            </a>
                        </td>
                        <td>{{ $c->played_match }}</td>
                        <td>{{ $c->points }}</td>
                        <td>
                            <div class='btn-group'>
                                <a class='' href='{{ route('admin#clubUpdatePage', $c->id) }}'>
                                    <i class='fa-solid fa-pen-to-square' title='Update'></i>
                                </a>
                                <a class='' href='{{ route('admin#clubDelete', $c->id) }}'>
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
