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
                            <h1>Update User</h1>
                            <p class="text-capitalize">User: <b>{{ $user->name }}</b> </p>
                        </div>

                    </div>

                    <div class="comment-first-section mt-5">

                        <form
                            id="updateUserForm"
                            data-validate=true
                            method="POST"
                            action="/user/update">
                            @csrf

                            <div class="row home-fill-section cstm-search home-search-area">

                                <div class="col-md-4 input-type-center">
                                    <label class="label-font">Name</label>
                                    <input type="text" class="form-control mt-0" name="name" value="{{ $user->name }}" placeholder="Name">
                                </div>

                                <div class="col-md-4 input-type-center">
                                    <label class="label-font">Email</label>
                                    <input type="email" class="form-control mt-0" name="email" value="{{ $user->email }}" placeholder="Email">
                                </div>

                                <div class="col-md-4 input-type-center">
                                    <label class="label-font">Role</label>
                                    <select name="role" id="" class="form-control">
                                        <option value="admin">Admin</option>
                                        <option value="editor">Editor</option>
                                    </select>
                                </div>

                                <div class="col-md-12 text-center mt-5">

                                    <h4>If a new password is required, please enter it. </h4>

                                </div>

                                <div class="col-md-6 mt-1 input-type-center">
                                    <label class="label-font">New Password</label>
                                    <input type="password" class="form-control mt-0" name="password" value="" id="password" placeholder="New Password">
                                </div>

                                <div class="col-md-6 mt-1 input-type-center">
                                    <label class="label-font">Confirm New Password</label>
                                    <input type="password" class="form-control mt-0" name="c_password" value="" placeholder="Confirm New Password">
                                </div>

                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                @include('_GeneralComponents.formDefaultSubmitButton')

                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection

@section('page-js')
<script src="{{ asset('assets/js/validations/userForm.js') }}"></script>
@endsection
