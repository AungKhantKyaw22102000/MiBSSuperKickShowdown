@extends('admin.layout.master')

@section('title', 'Matches Page')

@section('content')
    <!-- standing -->
    <div class="standing segments-page">
        <div class="container"><br>
            <div class="button-container ">
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('admin#footballMatchCreatePage') }}" class="custom-button" style="--clr:#BC13FE"><span class="d-block">Create Match</span><i></i></a>
                    </div>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Match ID</th>
                        <th>Team 1</th>
                        <th>Team 2</th>
                        <th>Play Date</th>
                        <th>Play Time</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($matches as $m)
                    <tr class='$rowClass'>
                        <td>{{ $m->id }}</td>
                        <td>
                            <a href="{{ route('admin#clubDetail', $m->team1_id) }}">
                                <img src="{{ asset('storage/clubPhoto/'. $m->team1_photo) }}" alt="{{ $m->team1_name }}" style="width: 20px; height: 20px;">{{ $m->team1_name }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin#clubDetail', $m->team2_id) }}">
                                <img src="{{ asset('storage/clubPhoto/'. $m->team2_photo) }}" alt="{{ $m->tem2_name }}" style="width: 20px; height: 20px;">{{ $m->team2_name }}
                            </a>
                        </td>
                        <td>{{ $m->play_date }}</td>
                        <td>{{ $m->play_time }}</td>
                        <td>
                            <div class='btn-group'>
                                <a class='' href='{{ route('admin#footballMatchUpdatePage', $m->id) }}'>
                                    <i class='fa-solid fa-pen-to-square' title='Update'></i>
                                </a>
                                <a class='' href='{{ route('admin#footballMatchDelete', $m->id) }}'>
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
