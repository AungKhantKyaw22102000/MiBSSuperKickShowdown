@extends('admin.layout.master')

@section('title', 'User List')

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
                        <h3>User List</h3>
                    </div>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th style="text-align: center">User Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admin as $a)
                    <tr class='$rowClass'>
                        <input type="hidden" value="{{ $a->id }}" class="userId">
                        <td style="text-align: center;">
                            @if($a->image == null)
                            <img src="{{ asset('image/default_user.jpg') }}" alt="{{ $a->name }}" style="width: 150px;" />
                            @else
                                <img src="{{ asset('storage/userPhoto/' . $a->image) }}" alt="{{ $a->name }}" style="width: 150px">
                            @endif
                        </td>
                        <td>{{ $a->name }}</td>
                        <td>{{ $a->email }}</td>
                        <td>
                            <select name="userRole" id="" class="changeUserRole">
                                <option value="user" @if ($a->role == 'user') selected @endif>User</option>
                                <option value="admin" @if ($a->role == 'admin') selected @endif>Admin</option>
                            </select>
                        </td>
                        <td>
                            <div class='btn-group'>
                                <a class='' href='{{ route('admin#adminUserDelete', $a->id) }}'>
                                    <i class='fa-solid fa-trash-can' title='Delete'></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-5">
                {{ $admin->links('vendor.pagination.pagination-links') }}
            </div>
        </div>
    </div>
    <!-- end standing -->
@endsection

@section('scriptSection')
<script>
    $(document).ready(function(){
        $('.changeUserRole').change(function(){
            $currentStatus = $(this).val();
            $parentNode = $(this).parents('tr');
            $userId = $parentNode.find('.userId').val();
            $data = {
                'userId' : $userId,
                'status' : $currentStatus
            };

            $.ajax({
                type : 'get' ,
                url : 'http://127.0.0.1:8000/admin/users/change/role',
                data : $data,
                dataType : 'json',
            })
        })
    })
</script>
@endsection
