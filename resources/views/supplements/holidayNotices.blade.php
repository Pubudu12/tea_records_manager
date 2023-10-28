@extends('theme.partials.home')

@section('content')

    <!-- Container-fluid starts-->
    <div class="page-body">

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="container-fluid">

                    <form id="reportForm" data-action-after=2 data-validate=true method="POST" action="/manipulateHolidayNotices">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="header-font1">Highlights </h1>
                                <small>Click on the <img src="{{ asset('assets/img/save.png') }}"> icon in the editor to save your data.</small>
                            </div>
                        </div>
                        
                        <div class="mt-3">                    
                            <div class="row">
                                <div class="col-md-12 crop-we-section">

                                    @if ($notices != NULL)
                                        <div class="comment-page-topic-section">
                                            <label for="">Title</label>
                                            <input class="form-control input-text1 header-font1 w-100" name="title" value="{{$notices->title}}" placeholder="Holiday Notices">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <textarea class="textarea_tinny_1" name="description" placeholder="Holiday Notices">{{$notices->description}}</textarea>
                                            </div>
                                        </div>
                                    @else
                                        <div class="comment-page-topic-section">
                                            <label for="">Title</label>
                                            <input class="form-control input-text1 header-font1 w-100" name="title" value="" placeholder="Holiday Notices">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <textarea class="textarea_tinny_1" name="description" placeholder="Holiday Notices"></textarea>
                                            </div>
                                        </div>
                                    @endif  

                                </div>
                            </div>
                        </div>

                        @include('_GeneralComponents.formBottomNextPrevOnly', ['previous'=>'/suppliments', 'next'=> '/dashboard'])

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection


