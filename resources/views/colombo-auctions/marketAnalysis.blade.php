@extends('theme.partials.home')

@section('content')

    <!-- Container-fluid starts-->
    <div class="page-body">

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="container-fluid">

                    <form id="reportForm" data-action-after=2 data-validate=true method="POST" action="/manipulateMarketAnalysisDescritions">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-40">
                                <h1 class="header-font1">{{$name}}</h1>
                            </div>
                        </div>
                        
                        <div class="comment-first-section">  
                            @if (count($marketDescriptions) > 0)
                                @foreach ($marketDescriptions as $desc)
                                    <div class="row mt-3">
                                        <div class="col-md-2">
                                            <label class="label-font">{{$desc->tea_grade}}</label>
                                            <input type="hidden" name="ref_tea_grade[]" value="{{$desc->tea_grade}}">
                                        </div>
                                        <div class="col-md-10">
                                            <textarea class="form-control" name="desc[]" placeholder="Description">{{$desc->description}}</textarea>
                                        </div>
                                    </div>
                                @endforeach  
                            @else
                                @foreach ($descriptionReferences['description_details'] as $refDescription)
                                    <div class="row mt-3">
                                        <div class="col-md-2">
                                            <label class="label-font">{{$refDescription}}</label>
                                            <input type="hidden" name="ref_tea_grade[]" value="{{$refDescription}}">
                                        </div>
                                        <div class="col-md-10">
                                            <textarea class="form-control" name="desc[]" placeholder="{{$refDescription}}"></textarea>
                                        </div>
                                    </div>
                                @endforeach  
                            @endif      
                           

                            <div class="col-12 mt-5">
                                <div class="row">
                                    <div class="col-md-6">
                                    </div>                        
                                    <div class="col-md-6 d-flex justify-content-end">
                                        <input type="hidden" name="elevation_id" value="{{$areaId}}">
                                        <button class="btn btn-success form-btn-submit" data-submitAfter="save"> SAVE </button>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </form>

                    <form id="reportForm" data-action-after=2 data-validate=true method="POST" action="/manipulateMarketAnalysis">
                        @csrf
                        <div class="comment-first-section">                            
                            <div class="row">
                                <table class="table" id="link_section">
                                    @foreach ($detailsArray as $key => $singleArr)
                                        @if ($singleArr['type'] == 'TITLE')
                                            <tr>
                                                <th class="text-center"> 
                                                    <h6>{{$singleArr['name']}}</h6>
                                                    <input type="hidden" name="name[]" value="{{$singleArr['name']}}">
                                                </th>
                                                @foreach ($singleArr['values'] as $valueKey => $singleValue)                                                        
                                                    <th class="text-center">{{$singleValue}}</th>
                                                    <input type="hidden" name="details[]" value="{{$singleValue}}">
                                                @endforeach                                                                  
                                            </tr>
                                        @else
                                            <tr class="add-link" id="add-link">
                                                <td class="text-right">
                                                    {{$singleArr['name']}}
                                                    <input type="hidden" name="name[]" value="{{$singleArr['name']}}">
                                                </td>
                                                @foreach ($singleArr['values'] as $valueKey => $singleValue)
                                                    <td class="text-center">
                                                        <input type="text" class="text-center custm-placeholder" name="details[]" placeholder="Value" value="{{$singleValue}}">
                                                        <div class="switch-toggle d-flex justify-content-center mt-2">   
                                                            
                                                            {{-- <td><input type="radio" name="id_project" value="{{ $value->id_project }}"  {{ old('id_project') == $value->id_project ? 'checked' : ''}} ></td> --}}
                                                            @if ($singleArr['status'][$valueKey] == '1')
                                                           
                                                                <input id="up_{{$key}}{{$valueKey}}" name="state_{{$key}}{{$valueKey}}" type="radio" tabindex="-1" checked value="1"/>
                                                                <label class="toggle_1" for="up_{{$key}}{{$valueKey}}" ><i class="fa fa-arrow-up" aria-hidden="true"></i></label>
                                                                
                                                                <input id="down_{{$key}}{{$valueKey}}" name="state_{{$key}}{{$valueKey}}" type="radio" tabindex="-1"  value="0"/>
                                                                <label class="toggle_2" for="down_{{$key}}{{$valueKey}}" ><i class="fa fa-arrow-down" aria-hidden="true"></i></label>

                                                                <input id="firm_{{$key}}{{$valueKey}}" name="state_{{$key}}{{$valueKey}}" type="radio" tabindex="-1" value="NO" />
                                                                <label class="toggle_3" for="firm_{{$key}}{{$valueKey}}" class="disabled" ><i class="fa fa-minus" aria-hidden="true"></i></label>
                                                                
                                                            @elseif ($singleArr['status'][$valueKey] == '0')

                                                                <input id="up_{{$key}}{{$valueKey}}" name="state_{{$key}}{{$valueKey}}" type="radio" tabindex="-1"  value="1"/>
                                                                <label class="toggle_1" for="up_{{$key}}{{$valueKey}}" ><i class="fa fa-arrow-up" aria-hidden="true"></i></label>
                                                                
                                                                <input id="down_{{$key}}{{$valueKey}}" name="state_{{$key}}{{$valueKey}}" type="radio" tabindex="-1" checked value="0"/>
                                                                <label class="toggle_2" for="down_{{$key}}{{$valueKey}}" ><i class="fa fa-arrow-down" aria-hidden="true"></i></label>

                                                                <input id="firm_{{$key}}{{$valueKey}}" name="state_{{$key}}{{$valueKey}}" type="radio" tabindex="-1" value="NO" />
                                                                <label class="toggle_3" for="firm_{{$key}}{{$valueKey}}" class="disabled" ><i class="fa fa-minus" aria-hidden="true"></i></label>

                                                            @elseif ($singleArr['status'][$valueKey] == 'NO')

                                                                <input id="up_{{$key}}{{$valueKey}}" name="state_{{$key}}{{$valueKey}}" type="radio" tabindex="-1" value="1"/>
                                                                <label class="toggle_1" for="up_{{$key}}{{$valueKey}}" ><i class="fa fa-arrow-up" aria-hidden="true"></i></label>
                                                                
                                                                <input id="down_{{$key}}{{$valueKey}}" name="state_{{$key}}{{$valueKey}}" type="radio" tabindex="-1" value="0"/>
                                                                <label class="toggle_2" for="down_{{$key}}{{$valueKey}}" ><i class="fa fa-arrow-down" aria-hidden="true"></i></label>

                                                                <input id="firm_{{$key}}{{$valueKey}}" name="state_{{$key}}{{$valueKey}}" checked type="radio" tabindex="-1" value="NO" />
                                                                <label class="toggle_3" for="firm_{{$key}}{{$valueKey}}" class="disabled" ><i class="fa fa-minus" aria-hidden="true"></i></label>
                                                            @endif                                                        
                                                            
                                                        </div>
                                                    </td>
                                                @endforeach
                                            </tr>  
                                        @endif
                                    @endforeach  
                                </table>
                            </div>
                        </div>                        

                        <input type="hidden" name="areaId" value="{{$areaId}}">

                        {{-- @switch($code)
                            @case('HIGH_GROWN')
                                <?php 
                                    $next = '/market-analysis/'.'MEDIUM_GROWN';
                                ?>

                                @include('_GeneralComponents.formBottomButtons', ['previous'=>'/crop-and-weather', 'next'=> $next])
                                @break

                            @case('MEDIUM_GROWN')
                                <?php 
                                    $previous = '/market-analysis/'.'HIGH_GROWN';
                                    $next = '/market-analysis/'.'UNORTHODOX';
                                ?>

                                @include('_GeneralComponents.formBottomButtons', ['previous'=>$previous, 'next'=> $next])
                                @break

                            @case('UNORTHODOX')
                                <?php 
                                    $previous = '/market-analysis/'.'MEDIUM_GROWN';
                                    $next = '/market-analysis/'.'OFF_GRADES';
                                ?>

                                @include('_GeneralComponents.formBottomButtons', ['previous'=>$previous, 'next'=> $next])
                                @break

                            @case('OFF_GRADES')
                                <?php 
                                    $previous = '/market-analysis/'.'UNORTHODOX';
                                    $next = '/market-analysis/'.'DUSTS';
                                ?>

                                @include('_GeneralComponents.formBottomButtons', ['previous'=>$previous, 'next'=> $next])
                                @break

                            @case('DUSTS')
                                <?php 
                                    $previous = '/market-analysis/'.'OFF_GRADES';
                                    $next = '/market-analysis/'.'LOW_GROWN';
                                ?>

                                @include('_GeneralComponents.formBottomButtons', ['previous'=>$previous, 'next'=> $next])
                                @break

                            @case('LOW_GROWN')
                                <?php 
                                    $previous = '/market-analysis/'.'DUSTS';
                                ?>

                                @include('_GeneralComponents.formBottomButtons', ['previous'=>$previous, 'next'=> '/top-prices'])
                                @break
                        
                            @default

                                <?php 
                                    $next = '/market-analysis/'.'MEDIUM_GROWN';
                                ?>
                                @include('_GeneralComponents.formBottomButtons', ['previous'=>'/crop-and-weather', 'next'=> $next])
                                
                        @endswitch --}}

                        @include('_GeneralComponents.formBottomButtons', ['previous'=>$previous, 'next'=> $next])

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection