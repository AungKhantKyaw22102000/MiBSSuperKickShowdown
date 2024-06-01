@extends('admin.layout.master')

@section('title', 'User List')

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
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admin as $a)
                    <tr class='$rowClass'>
                        <td>{{ $a->id }}</td>
                        <td>{{ $a->name }}</td>
                        <td>{{ $a->email }}</td>
                        <td>
                            <select name="userRole" id="" class="form-control changeUserRole">
                                <option value="user" @if ($a->role == 'user') selected @endif>User</option>
                                <option value="admin" @if ($a->role == 'admin') selected @endif>Admin</option>
                            </select>
                        </td>
                        <td>
                            <div class='btn-group'>
                                <a class='' href=''>
                                    <i class='fa-solid fa-pen-to-square' title='Update'></i>
                                </a>
                                <a class='' href=''>
                                    <i class='fa-solid fa-trash-can' title='Delete'></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-5">
                {{ $admin->links() }}
                {{-- {{ $categories->appends(request()->query())->links() }} --}}
            </div>
        </div>
    </div>
    <!-- end standing -->
@endsection
