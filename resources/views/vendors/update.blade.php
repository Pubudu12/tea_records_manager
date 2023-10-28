@extends('theme.partials.home')

@section('content')

    <!-- Container-fluid starts-->
    <div class="page-body">

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="container-fluid">                    
                        
                    <div class="row">
                        <div class="col-md-12 mb-40">
                            <h1 class="header-font1">Update Broker</h1>
                            <h6>{{$data->name}}</h6>
                            {{-- <p>Comments | National Tea Sales Average | National Tea Exports</p> --}}
                        </div>
                    </div>

                    {{-- <form action="" method="POST" id="commentForm"> --}}
                    <form id="reportForm" data-action-after=2 data-redirect-url="" method="POST"
                        action="/update_vendor">
                            @csrf
                        <div class="comment-first-section">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <label for="">Broker Name</label>
                                    <input class="form-control input-text1" name="name" id="" value="{{$data->name}}">

                                    <label class="mt-4" for="">Broker Initials</label>
                                    <input class="form-control input-text1" value="{{$data->keyword}}" name="keyword" id="">
                                </div>
                                <div class="col-md-2"></div>
                            </div>

                            {{-- <div class="row">
                                <div class="col-md-6"></div>

                                <div class="col-md-6">
                                    <input type="hidden" name="id" value="{{$data->id}}">
                                    <button class="reference_up_btn next-btn custom-btn-save btn-submit float-right"> SAVE </button>
                                </div>
                            </div> --}}
                            <input type="hidden" name="id" value="{{$data->id}}">
                            @include('_GeneralComponents.formBottomButtons', ['previous'=>'/vendors', 'next'=> '/vendors'])

                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection