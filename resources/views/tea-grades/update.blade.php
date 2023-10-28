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
                        <div class="col-md-12 mb-40">
                            <h1 class="header-font1">Update Tea Grade</h1>
                            <h6>{{$data->name}}</h6>
                            {{-- <p>Comments | National Tea Sales Average | National Tea Exports</p> --}}
                        </div>
                    </div>

                    {{-- <form action="" method="POST" id="commentForm"> --}}
                    <form data-action-after=2 data-redirect-url="" method="POST"
                        action="/update_tea-grade">
                            @csrf
                        <div class="comment-first-section">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <label for="">Tea Grade Name</label>
                                    <input class="form-control input-text1" name="name" id="" value="{{$data->name}}">

                                    <label class="mt-4" for="">Tea Grade Keyword</label>
                                    <input class="form-control input-text1" name="keyword" id="" value="{{$data->keyword}}">

                                </div>
                                <div class="col-md-2"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-6"></div>

                                <div class="col-md-6">
                                    <input type="hidden" name="id" value="{{$data->id}}">
                                    <button class="reference_up_btn next-btn custom-btn-save btn-submit float-right"> SAVE </button>
                                </div>
                            </div>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection