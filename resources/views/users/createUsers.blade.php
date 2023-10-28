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
                            <p>Create new user (Admin, Editor)</p>
                        </div>

                    </div>

                    <div class="comment-first-section mt-5">

                        <form
                            id="userForm"
                            data-validate=true
                            method="POST"
                            action="/user/create">
                            @csrf

                            <div class="row home-fill-section cstm-search home-search-area">

                                <div class="col-md-4 input-type-center">
                                    <label class="label-font">Name</label>
                                    <input type="text" class="form-control mt-0" name="name" value="" placeholder="Name">
                                </div>

                                <div class="col-md-4 input-type-center">
                                    <label class="label-font">email</label>
                                    <input type="email" class="form-control mt-0" name="email" value="" placeholder="Email">
                                </div>

                                <div class="col-md-4 input-type-center">
                                    <label class="label-font">Role</label>
                                    <select name="role" id="" class="form-control">
                                        <option value="admin">Admin</option>
                                        <option value="editor">Editor</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mt-5 input-type-center">
                                    <label class="label-font">Password</label>
                                    <input type="password" class="form-control mt-0" name="password" value="" id="password" placeholder="Password">
                                </div>

                                <div class="col-md-6 mt-5 input-type-center">
                                    <label class="label-font">Confirm Password</label>
                                    <input type="password" class="form-control mt-0" name="c_password" value="" placeholder="Confirm Password">
                                </div>

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
