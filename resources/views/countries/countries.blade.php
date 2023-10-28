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
                                <h1 class="header-font1">Countries</h1>
                                <p>Countries are used in the "Major Importers of Sri Lanka" Section. </p>
                            </div>
                        </div>

                        {{-- @include('comments.include.forms.overallSaleForm') --}}
                        <div class="row">
                            <col class="col-md-6"></div>
                            <col class="col-md-6">
                                <a class="next-btn custom-btn-save float-right btn-top" href="/country/create">Create Country</a>
                            </div>
                        </div>
                      
                        <div class="comment-first-section mt-4">                            
                            <table class="dataListTable table" id="dataListTable">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Name</td>
                                        <td>Keyword</td>
                                        <td>Action</td>
                                    </tr>                                    
                                </thead>
                                <tbody>
                                    @foreach ($countries as $key => $country)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$country->name}}</td>
                                            <td>{{$country->keyword}}</td>
                                            <td>
                                                <a class="btn btn-sm btn-outline-primary" href="/country/update/{{ $country->id }}"><i class="fa fa-edit"></i></a>
                                                <button class="btn btn-sm btn-outline-danger" data-submitAfter="refresh" data-refresh="countries" data-url="/delete_country/{{ $country->id }}" data-id="{{ $country->id }}" onclick="deleteItem(this)"><i class="fa fa-trash"></i></button>
                                            </td>
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