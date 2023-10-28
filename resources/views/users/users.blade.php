@extends('theme.partials.home')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Container-fluid starts-->
    <div class="page-body">

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 home-indx">
                            <h1>Users</h1>
                            <p>Users list</p>
                        </div>
                        <div class="col-md-6 mt-5">
                            <a href="/user/create" class="dash-btn next-btn custom-btn-save">CREATE USER</a>
                        </div>
                    </div>

                    <div class="comment-first-section mt-5">
                        <table class="dataListTable table" id="dataListTable">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Email</td>
                                    <td>Name</td>
                                    <td>Role</td>
                                    <td>Status</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($users as $key => $user)
                                    <tr>
                                        <td> {{$key+1}} </td>
                                        <td>{{ $user['email'] }}</td>
                                        <td>{{ $user['name'] }}</td>
                                        <td>{{ $user['role'] }}</td>
                                        <td>
                                            @if ($user['published'] == '1')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Blocked</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-outline-primary" href="/user/update/{{ $user['id'] }}"><i class="fa fa-edit"></i></a>
                                            {{-- <a class="btn btn-sm btn-outline-danger" href="/user/delete/{{ $user['id'] }}"><i class="fa fa-trash"></i></a> --}}
                                            <button class="btn btn-sm btn-outline-danger" data-submitAfter="refresh" data-refresh="countries" data-url="/user/delete/{{ $user['id'] }}" data-id="{{ $user['id'] }}" onclick="deleteItem(this)"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection
