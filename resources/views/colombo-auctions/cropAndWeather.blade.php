@extends('theme.partials.home')

@section('content')

    <!-- Container-fluid starts-->
    <div class="page-body">

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="container-fluid">
                <form id="reportForm" data-action-after=2 data-validate=true method="POST" action="/manipulateCrops">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="header-font1">Crop And Weather</h1>
                        </div>
                    </div>
                    
                    <div class="row mt-4">                           
                        <div class="col-md-12 crop-we-section section-padding">
                            <div class="">
                                <h3 class="sub-sub-ttl">Date Duration</h3>
                                
                                @if (count($weatherDetails) > 0)
                                    <div class="form-row">
                                        <div class="row order-ttl-row1">
                                            <div class="col-md-6">
                                                <div class="form-group order-ttl-flex1">
                                                    {{-- <label class="label-font" for="inputAddress">From</label> --}}
                                                    <input type="text" class="form-control" name="date_duration" value="{{$weatherDetails[0]->date_duration}}"  placeholder="13th March - 19th March">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" class="btn sm-add" onclick="addLink()" id="add_link_btn"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach ($weatherDetails as $singleWeather)

                                        <div class="mt-5"> 
                                            <div id="link_section">    
                                                <div id="add-link">         
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="">Region</label>
                                                            <input type="text" class="form-control" name="region[]" value="{{$singleWeather->title}}" placeholder="Region">
                                                        </div> 
                                                        <div class="col-md-6">
                                                            <label for="">Weather</label>
                                                            <select name="weather[]" id="" class="form-control weather-types">
                                                                @foreach ($weatherTypes as $type)
                                                                    <option <?php echo ($singleWeather->weather == $type['code']) ? 'selected':'' ?> value="{{$type['code']}}">{{$type['name']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>    
                                                    </div>                               
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <label for="">Brief on weather</label>
                                                            <textarea name="small_desc[]" class="form-control" id="" rows="1">{{$singleWeather->small_description}}</textarea>
                                                            <small class="text-danger">Use not more than <b>60</b> words</small>     
                                                        </div>                                                                                                           
                                                    </div>    
                                                    <div>&nbsp;
                                                        <button class="btn remove-btn-1" type="button" id="removeLink" onclick="removeCrop(this)"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                    <hr class="mt-5 mb-4"> 
                                                </div> 
                                            </div>                                                                                      
                                        </div>
                                    @endforeach
                                @else
                                    <div class="form-row">
                                        <div class="row order-ttl-row1">
                                            <div class="col-md-6">
                                                <div class="form-group order-ttl-flex1">
                                                    {{-- <label class="label-font" for="inputAddress">From</label> --}}
                                                    <input type="text" class="form-control " name="date_duration"  placeholder="13th March - 19th March">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" class="btn sm-add" onclick="addWeatherLink()" id="add_link_btn"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-5"> 
                                        <div id="link_section">    
                                            <div id="add-link">         
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="">Region</label>
                                                        <input type="text" class="form-control" name="region[]" placeholder="Region">
                                                    </div> 
                                                    <div class="col-md-6">
                                                        <label for="">Weather</label>
                                                        <select name="weather[]" id="" class="form-control js-example-basic-single">
                                                            @foreach ($weatherTypes as $type)
                                                                <option value="{{$type['code']}}">{{$type['name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>    
                                                </div>                               
                                                <div class="row mt-2">
                                                    <div class="col-md-12">
                                                        <label for="">Brief on weather</label>
                                                        <textarea name="small_desc[]" class="form-control" id="" rows="1"></textarea>
                                                        <small class="text-danger">Use not more than <b>60</b> words</small>     
                                                    </div>                                                                                                           
                                                </div>    
                                                <div>&nbsp;
                                                    <button class="btn remove-btn-1" type="button" id="removeLink" onclick="removeCrop(this)"><i class="fa fa-trash"></i></button>
                                                </div>
                                                <hr class="mt-5 mb-4"> 
                                            </div> 
                                        </div>                                                                                      
                                    </div>
                                @endif
                                
                            </div>
                        </div>
                    </div>

                    <div>                
                        <div class="row">
                            <div class="col-md-12 crop-we-section section-padding">
                                
                                <div class="row mt-3" id="">
                                    <div class="col-md-12">
                                        <h5><b>Crop</b></h5>
                                        @if ($cropDetails == NULL)
                                            <textarea name="cropdesc" class="form-control" id="" rows="3"></textarea>  
                                            <small class="text-danger">Use not more than <b>60</b> words</small>                                          
                                        @else
                                            <textarea name="cropdesc" class="form-control" id="" rows="3">{{$cropDetails->small_description}}</textarea>                                            
                                            <small class="text-danger">Use not more than <b>60</b> words</small>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    @include('_GeneralComponents.formBottomButtons', ['previous'=>'/order-of-sales', 'next'=> '/market-analysis/HIGH_GROWN'])

                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
