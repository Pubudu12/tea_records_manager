@extends('theme.partials.home')

@section('content')

    <!-- Container-fluid starts-->
    <div class="page-body">

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="container-fluid">

                    <form id="reportForm" data-action-after=2 data-validate=true method="POST" action="/manipulateNewPageContent">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="header-font1">New Page Content </h1>
                                <small>Click on the <img src="{{ asset('assets/img/save.png') }}"> icon in the editor to save your data.</small>
                            </div>
                        </div>
                        
                        <div class="mt-3">                    
                            <div class="row">
                                <div class="col-md-12 crop-we-section">
                                    
                                    <div class="comment-page-topic-section">
                                        <label for="">Title</label>
                                        <input class="form-control input-text1 header-font1 w-100" name="title" value="{{$details['title']}}" placeholder="New Page Content">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea class="textarea_tinny_1" name="content" placeholder="New Page Content">{{$details['content']}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="type" value="{{$details['type']}}">
                        @include('_GeneralComponents.formBottomNextPrevOnly', ['previous'=>'/suppliments', 'next'=> '/dashboard'])

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection


