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
                            <h1 class="header-font1">Update Country</h1>
                            <h6>{{$data->name}}</h6>
                            {{-- <p>Comments | National Tea Sales Average | National Tea Exports</p> --}}
                        </div>
                    </div>

                    {{-- <form action="" method="POST" id="commentForm"> --}}
                    <form data-action-after=2 data-redirect-url="" method="POST"
                        action="/update_country">
                            @csrf
                        <div class="comment-first-section">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <label for="">Country Name</label>
                                    <input class="form-control input-text1" name="name" id="" value="{{$data->name}}">

                                    {{-- <label class="mt-4" for="">Country Keyword</label>
                                    <input class="form-control input-text1" name="keyword" id="" value="{{$data->keyword}}">

                                    <label class="mt-4" for="">Order</label>
                                    <input class="form-control input-text1" name="order" id="" value="{{$data->order}}"> --}}
                                </div>
                                <div class="col-md-2"></div>
                            </div>

                            {{-- <div class="row">
                                <div class="col-md-6"></div>

                                <div class="col-md-6">
                                   
                                    <button class="reference_up_btn next-btn custom-btn-save btn-submit float-right"> SAVE </button>
                                </div>
                            </div> --}}
                            <input type="hidden" name="id" value="{{$data->id}}">
                            @include('_GeneralComponents.formBottomButtons', ['previous'=>'/countries', 'next'=> '/countries'])
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection