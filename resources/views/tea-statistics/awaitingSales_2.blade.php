@extends('theme.partials.home')

@section('content')

    <!-- Container-fluid starts-->
    <div class="page-body">

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">                
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="header-font1">Details of Awaiting Sale</h1>
                                {{-- <h6>Sale No : 09</h6> --}}
                            </div>
                        </div>    

                        <?php 
                            $value = session()->get('sale_code');
                            if($value != NULL){
                                $pieces = str_split($value,4);
                                $no = str_split($pieces[1],1);
                                $num = $no[1].$no[2];
                                $num = $num+2;
                            }
                        ?>
                        
                        <div>
                            <div class="row">
                                <div class="col-md-12 crop-we-section">
                                    <form id="reportForm" data-action-after=2 data-validate=true method="POST" action="/manipulateAwaitingLotsQtyDetails">
                                        @csrf
                                        <div class="row mb-20 mt-20">
                                            <div class="col-md-6 staticsLblDiv">
                                                <label class="label-font mr-12">Sale No</label>
                                                
                                                <input type="text" class="form-control input-text1" name="sale_code" value="{{$awaiting_sale_code}}" readonly placeholder="Sale Code">
                                                <input type="hidden" name="sale_no" value="{{$num}}">
                                            </div>
                                            <div class="col-md-6 staticsLblDiv1">
                                                <label class="label-font mr-12">Scheduled For</label>
                                                <input type="date" class="form-control input-text1" name="sale_scheduled_date" value="{{$saleReportDay_1}}" placeholder="Date">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table">                                        
                                                    <tbody>
                                                        <tr class="lcl-mrt-tbl">
                                                            <td class="local-mar-col-name"></td>
                                                            <td class="local-mar-col-name">Lots</td>
                                                            <td class="local-mar-col-name">Quantity</td>
                                                        </tr>
                                                
                                                        @if (count($fetchAwaitingLotsQty) != 0)
                                                            @foreach ($fetchAwaitingLotsQty as $key => $singleDetail)
                                                                <tr>    
                                                                    <td>
                                                                        <div class="text-right {{($singleDetail->refCode == 'TOTAL')?'font-weight-bold':''}}" name="ref-name" value="">{{$singleDetail->refName}}</div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input class="form-control text-center {{($singleDetail->refCode == 'TOTAL') ? 'font-weight-bold totLotsVal' : 'lotsVal'}}" name="lots_value[]" value="{{$singleDetail->lots_value}}" onkeyup="calculateLots()" placeholder="Lots">
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control text-center {{($singleDetail->refCode == 'TOTAL') ? 'font-weight-bold totQtyVal' : 'qtyVal'}}" name="quantity[]" value="{{$singleDetail->quantity}}" onkeyup="calculateQty()" placeholder="Quantity">
                                                                    </td>                                     
                                                                </tr> 
                                                            @endforeach    
                                                        @else
                                                            @foreach ($references as $reference)
                                                                <tr>
                                                                    <td>
                                                                        <div class="text-right {{($reference->code == 'TOTAL') ? 'font-weight-bold':''}}" name="ref-name" value="">{{$reference->name}}</div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input class="form-control text-center {{($reference->code == 'TOTAL') ? 'font-weight-bold totLotsVal' : 'lotsVal'}}" name="lots_value[]" placeholder="Lots" onkeyup="calculateLots()">
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control text-center {{($reference->code == 'TOTAL') ? 'font-weight-bold totQtyVal' : 'qtyVal'}}" name="quantity[]" placeholder="Quantity" onkeyup="calculateQty()">
                                                                    </td>                                       
                                                                </tr>    
                                                            @endforeach    
                                                        @endif 
                                                    </tbody>                                                
                                                </table>
                                            </div>
                                        </div> 

                                        <div class="col-12 mt-5">
                                            <div class="row">                                        
                                                <div class="col-md-12 d-flex justify-content-end">
                                                    <button class="btn btn-success form-btn-submit" data-submitAfter="save"> SAVE </button>
                                                </div>
                                            </div>                                        
                                        </div>                                       

                                    </form>

                                    <form id="reportForm1" data-action-after=2 data-validate=true method="POST" action="/manipulateAwaitingcatelogues">
                                        @csrf

                                        {{-- Catelogues start --}}
                                        <input type="hidden" class="form-control input-text1" name="sale_code" value="{{$pieces[0].'-'.$num}}" placeholder="Sale Code">
                                        <div class="row mt-5">
                                            {{-- @if (count($catalogDetails) > 0 ) --}}
                                                @foreach ($catalogDetails as $singleCatalogue)
                                                    <div class="col-md-6">
                                                        <p class="tblSubTtl mt-40">{{$singleCatalogue['name']}}</p>
                                                        <input type="hidden" name="code[]" value="{{$singleCatalogue['code']}}">

                                                        <div class="row mt-3">
                                                            <div class="col-md-6">
                                                                <label for="">Violations Excluded</label>
                                                                <input type="date" class="form-control" name="catg_date[]" value="{{$singleCatalogue['date']}}" placeholder="Date">
                                                            </div>
                                                        </div>

                                                        <table class="table mt-4">                                
                                                            <tbody>   
                                                                @foreach ($singleCatalogue['references'] as $key => $ref)
                                                                    <tr>
                                                                        <td class="local-mar-row-name text-trans-unset">{{$ref}}</td>
                                                                        <td class="">
                                                                            <input type="text" class="form-control" name="value[]" value="{{$singleCatalogue['values'][$key]}}" placeholder="Value">    
                                                                        </td>
                                                                    </tr>
                                                                @endforeach 
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endforeach
                                            </div>                                            

                                        {{-- Package Details --}}
                                        <div class="row mt-5 light-yellow-cell bg-package">
                                            <div class="col-md-12">
                                                <p class="tblSubTtl mt-40">Package Details</p>

                                                <div class="row mt-3">
                                                    <div class="col-md-6">
                                                        <label for="">No. of PKGS</label>
                                                        <input type="text" class="form-control" name="no_of_pkgs" value="{{$no_of_packages}}" placeholder="No. of PKGS">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="">CTC</label>
                                                        <input type="text" class="form-control" name="ctc" value="{{$ctc}}" placeholder="CTC">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-12 mt-5">
                                                <div class="row">                                        
                                                    <div class="col-md-12 d-flex justify-content-end">
                                                        <button class="btn btn-success form-btn-submit" data-submitAfter="save"> SAVE </button>
                                                    </div>
                                                </div>                                        
                                            </div>
                                        </div> 
                                    </form>                                    
                                   
                                    <form id="reportForm1" data-action-after=2 data-validate=true method="POST" action="/catelogueClosureDetails">
                                        @csrf
                                        <div class="table-cell-light-blue bg-package">
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <p class="tblSubTtl mt-40">Catalogue Closure Details</p>
                                                </div>
                                            </div>

                                            @foreach ($awaitingCatalogueClosures as  $key => $singleValue)
                                                <div>
                                                    <span class="catalog-closure-number">{{$key+1}}</span>
                                                    <div class="row mt-4">
                                                        <div class="col-md-3">
                                                            <small><b>Two Days in text</b></small>
                                                            <input type="text" class="form-control" placeholder="27/28" value="{{$singleValue['date_in_text']}}" name="date_in_text[]" id="">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <small><b>Month</b></small>
                                                            <select class="form-control" name="month[]" id="month">
                                                                @foreach ($months as $month)
                                                                    <option value="{{$month->id}}" {{($month->id == $singleValue['month']) ? 'selected': ''}}>{{$month->name}}</option>
                                                                @endforeach                                                            
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <small><b>Year</b></small>
                                                            <select class="form-control" name="year[]" id="">
                                                                @foreach ($yearList as $year)
                                                                    <option value="{{$year}}" {{($year == $singleValue['year']) ? 'selected': ''}}>{{$year}}</option>
                                                                @endforeach                                                            
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <small><b>Sale Number</b></small>
                                                            <input type="text" class="form-control" value="{{$singleValue['sale_number']}}" placeholder="Sale Number" name="sale_no[]" id="">
                                                        </div>
                                                        <div class="col-md-12 mt-3">
                                                            <small><b>Small Description</b></small>
                                                            <textarea type="text" class="form-control" placeholder="Small Description" rows="2" name="desc[]" id="">{{$singleValue['small_description']}}</textarea>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <hr>
                                            @endforeach  

                                        {{-- 
                                            <div>
                                                <span class="catalog-closure-number">2</span>
                                                <div class="row mt-4">
                                                    <div class="col-md-4">
                                                        <small><b>Two Days in text</b></small>
                                                        <input type="date" class="form-control" name="" id="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <small><b>Day 2</b></small>
                                                        <input type="date" class="form-control" name="" id="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <small><b>Sale Number</b></small>
                                                        <input type="text" class="form-control" placeholder="Sale Number" name="" id="">
                                                    </div>
                                                    <div class="col-md-12 mt-3">
                                                        <small><b>Small Description</b></small>
                                                        <textarea type="text" class="form-control" placeholder="Small Description" rows="2" name="" id=""></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div>
                                                <span class="catalog-closure-number">3</span>
                                                <div class="row mt-4">
                                                    <div class="col-md-4">
                                                        <small><b>Day 1</b></small>
                                                        <input type="date" class="form-control" name="" id="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <small><b>Day 2</b></small>
                                                        <input type="date" class="form-control" name="" id="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <small><b>Sale Number</b></small>
                                                        <input type="text" class="form-control" placeholder="Sale Number" name="" id="">
                                                    </div>
                                                    <div class="col-md-12 mt-3">
                                                        <small><b>Small Description</b></small>
                                                        <textarea type="text" class="form-control" placeholder="Small Description" rows="2" name="" id=""></textarea>
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <div class="col-12 mt-5">
                                                <div class="row">                                        
                                                    <div class="col-md-12 d-flex justify-content-end">
                                                        <input type="hidden" name="awaiting_sale_code" value="{{$awaiting_sale_code}}">
                                                        <button class="btn btn-success form-btn-submit" data-submitAfter="save"> SAVE </button>
                                                    </div>
                                                </div>                                        
                                            </div>                                            
                                        </div>
                                    </form>
                                </div>
                            </div>                 
                        </div>

                        @include('_GeneralComponents.formBottomNextPrevOnly', ['previous'=>'/awaitingSales1', 'next'=> '/world-tea-descriptions'])

                    </div>                
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('page-js')
    <script src="{{ asset('assets/js/form/calculations/awaitingSales.js') }}"></script>
@endsection