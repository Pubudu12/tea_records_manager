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
                            <h1 class="header-font1">Create Country</h1>
                            {{-- <p>Comments | National Tea Sales Average | National Tea Exports</p> --}}
                        </div>
                    </div>

                    {{-- <form action="" method="POST" id="commentForm"> --}}
                    <form data-action-after=2 data-redirect-url="" method="POST"
                        action="/create_country">
                            @csrf
                        <div class="comment-first-section">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <label for="">Country Name</label>
                                    <input class="form-control input-text1" name="name" id="">

                                    {{-- <label class="mt-4" for="">Country Keyword</label>
                                    <input class="form-control input-text1" name="keyword" id="">

                                    <label class="mt-4" for="">Order</label>
                                    <input class="form-control input-text1" name="order" id=""> --}}
                                </div>
                                <div class="col-md-2"></div>
                            </div>

                            
                            @include('_GeneralComponents.formBottomButtons', ['previous'=>'/countries', 'next'=> '/countries'])
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection