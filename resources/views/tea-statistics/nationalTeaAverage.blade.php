@extends('theme.partials.home')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Container-fluid starts-->
    <div class="page-body">

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="container-fluid">
                    <form id="reportForm" data-action-after=2 data-validate=true method="POST" action="/manipulateNationTeaDescriptions">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="header-font1">National Tea Sales Average</h1>
                                <small>Click on the <img src="{{ asset('assets/img/save.png') }}"> icon in the editor to save your data.</small>
                            </div>
                        </div>

                        @if ($description == NULL)                           
                            
                            <div class="crop-we-section"> 
                                                        
                                <div class="col-12">
                                    <div class="link_section" id="link_section">
                                        <div class="add-link mb-40 pb-25" id="add-link">                                               
                                            <div class="comment-page-topic-section ">
                                                <label for="">Description Title</label>
                                                <input class="form-control input-text1 header-font1 w-100" name="title" value="" placeholder="National Tea Sales Average">
                                            </div>

                                            <textarea class="textarea_tinny_1" name="description" placeholder="Hello, World!"></textarea>    
                                        </div>
                                    </div>                            
                                </div>   
                            </div> 
                        @else
                            
                            <div class="crop-we-section">                                                         
                                <div class="col-12">
                                    <div class="link_section" id="link_section">
                                        <div class="add-link mb-40 pb-25" id="add-link">                                               
                                            <div class="comment-page-topic-section ">
                                                <label for="">Description Title</label>
                                                <input class="form-control input-text1 header-font1 w-100" name="title" value="{{$description->title}}" placeholder="National Tea Sales Average">
                                            </div>

                                            <textarea class="textarea_tinny_1" name="description" placeholder="Hello, World!">{{$description->description}}</textarea>    
                                        </div>
                                    </div>                            
                                </div>   
                            </div> 
                        @endif
                       
                        <input type="hidden" name="type" value="NATIONAL_TEA_SALE_AVERAGE">
                        @include('_GeneralComponents.formBottomNextPrevOnly', ['previous'=>'/rates-of-exchange', 'next'=> '/weekly-tea-sales-average'])

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


