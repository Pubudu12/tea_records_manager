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
                            <h1 class="header-font1">Manage Marks </h1>
                            <h5>Marks under <b>{{$data->name}}</b></h5>
                            <p>Click on add button to add a field for a Mark. Type your Mark's name and click on save, <br>so that all the marks will be saved under {{$data->name}}.</p>
                        </div>
                    </div>

                    {{-- <form action="" method="POST" id="commentForm"> --}}
                   
                    <div class="comment-first-section">                       
                        
                        @if (count($childMarks) > 0)
                            <div class="row">
                                <label class="text-center">Existing Marks</label>
                            </div>
                            @foreach ($childMarks as $mark)
                                <div id="outter">
                                    <div>
                                        <div class="row mt-2">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-6">                                       
                                                <input class="form-control input-text1" name="name[]" value="{{$mark->name}}">
                                            </div>
                                            <div class="col-md-1 mt-1">
                                                <button class="btn btn-sm btn-outline-danger" data-submitAfter="refresh" data-url="/delete_ref_top_price/{{ $mark->id }}" data-id="{{ $mark->id }}" onclick="removeMarkWithDBdata(this)"><i class="fa fa-trash"></i></button>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach   
                        @endif                        
                        

                        <form class="mt-5 pt-3" data-action-after=1 data-redirect-url="" method="POST"
                                    action="/addTopPriceMarks">
                                    @csrf

                            <div class="col-md-12">
                                <button type="button" class="btn sm-add" data-toggle="tooltip" title="Click on this to add a field for a Mark" onclick="addTopPriceMark()" id="add_link_btn"><i class="fa fa-plus"></i></button>
                            </div>
                            <div class="row">
                                <label class="text-center">Add New Marks</label>
                            </div>

                            <div id="link_section">
                                <div class="row mt-2" id="add-link">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6">                                       
                                        <input class="form-control input-text1" name="name[]">

                                    </div>
                                    <div class="col-md-1 mt-1">
                                        <a class="btn btn-sm btn-outline-danger" data-toggle="tooltip" title="Delete mark" onclick="removeMark(this)" id="report_sales_code"><i class="fa fa-trash"></i></a>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                            </div>

                            <div class="col-12 mt-5 pt-5">
                                <div class="row">                            
                                    <div class="col-md-12 d-flex justify-content-end">
                                        <input type="hidden" name="code" value="{{$data->code}}">
                                        <button class="btn btn-success form-btn-submit" type="submit" data-submitAfter=""> SAVE </button>
                                    </div>
                                </div>                            
                            </div>
                        </form>
                    </div>     
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
{{-- 
    <script>
        function handleChange(checkbox) {            
            if(checkbox.checked == true){
                document.getElementById("parent").classList.remove("d-none");
            }else{
                document.getElementById("parent").classList.add("d-none");  
            }
        }
    </script> --}}
@endsection

@section('page-js')
    <script src="{{ asset('assets/js/form/removeMark.js') }}"></script>
@endsection