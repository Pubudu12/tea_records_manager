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
                            <h1>Home</h1>
                            <p>Welcome to the F&W Marketing Report Generator</p>
                        </div>

                    </div>

                    <div class="comment-first-section mt-5">

                        <form method="POST" action="/login">
                            @csrf
                            <div class="row home-fill-section cstm-search home-search-area">

                                <div class="col-md-3 input-type-center">
                                    <label class="label-font">Sales No</label>
                                    <input type="text" class="form-control mt-0" name="sale_no" id="sale_no" value="">
                                </div>

                                <div class="col-md-3 input-type-center">
                                    <input type="text" placeholder="Email" id="email" class="form-control" name="email" required
                                        autofocus>
                                    @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <input type="password" placeholder="Password" id="password" class="form-control" name="password" required>
                                    @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                                <div class="d-grid mx-auto">
                                    <button type="submit" class="btn btn-dark btn-block">Signin</button>
                                </div>

                            </div>
                        </form>

                        <form>
                            <div class="row home-fill-section cstm-search home-search-area">
                                <div class="col-md-3 input-type-center">
                                    <label class="label-font">Sales No</label>
                                    <input type="text" class="form-control mt-0" name="sale_no" id="sale_no" value="">
                                </div>
                                <div class="col-md-3 input-type-center">
                                    <label class="label-font">Year</label>
                                </div>
                                <div class="col-md-4 input-type-center">
                                    <label class="label-font">Date</label>
                                    <input type="date" class="form-control mt-0" id="date" value="" name="date">
                                </div>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endsection
