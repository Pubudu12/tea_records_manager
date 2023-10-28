@extends('theme.partials.home')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Container-fluid starts-->
    <div class="page-body">

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="container-fluid">
                    <form action="" method="" id="commentForm">                        
                        <div class="row">
                            <div class="col-md-12 mb-40">
                                <h1 class="header-font1">User Actions</h1>
                                {{-- <p>Countries are used in the "Major Importers of Sri Lanka" Section. </p> --}}
                            </div>
                        </div>
                        {{-- <div class="row">
                            <col class="col-md-6"></div>
                            <col class="col-md-6">
                                <a class="next-btn custom-btn-save float-right btn-top" href="/country/create">Create Country</a>
                            </div>
                        </div> --}}
                      
                        <div class="comment-first-section mt-4">                            
                            <table class="dataListTable table table-layout-fixed" id="dataListTable">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>User Name</td>
                                        <td>Event Type</td>
                                        <td>Model</td>
                                        <td>Old Values</td>
                                        <td>New Values</td>
                                    </tr>                                    
                                </thead>
                                <tbody>
                                    @foreach ($auditTrails as $key => $action)
                                        <tr>
                                            <td class="break-word">{{$key+1}}</td>
                                            <td class="break-word">{{$action->userName}}</td>                                            
                                            <td class="break-word">{{$action->event}}</td>
                                            <td class="break-word">{{$action->auditable_type}}</td>
                                            <td class="break-word">{{$action->old_values}}</td>
                                            <td class="break-word">{{$action->new_values}}</td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection