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
                            <h1 class="header-font1">Create Broker</h1>
                        </div>
                    </div>
                  
                    <form id="reportForm" data-action-after=2 data-validate=true method="POST" action="/createVendor">
                        @csrf
                        <div class="comment-first-section">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <label for="">Broker Name</label>
                                    <input class="form-control input-text1" name="name" id="">

                                    <label class="mt-4" for="">Broker Initials</label>
                                    <input class="form-control input-text1" name="keyword" id="">

                                    {{-- <label class="mt-4" for="">Broker Order</label>
                                    <input class="form-control input-text1" name="order" id=""> --}}
                                </div>
                                <div class="col-md-2"></div>
                            </div>

                            @include('_GeneralComponents.formBottomButtons', ['previous'=>'/vendors', 'next'=> '/vendors'])

                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection