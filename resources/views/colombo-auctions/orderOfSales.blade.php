@extends('theme.partials.home')

@section('content')

    <!-- Container-fluid starts-->
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">

                {{-- {{$orderOfSaleDetails}} --}}
                
                <form id="reportForm" data-action-after=2 data-validate=true method="POST" action="/manipulateOrderOfSale">
                    @csrf
                    <div class="mt-2">                  
                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="header-font1">Order of Sales</h1>
                            </div>

                            <div class="col-md-12 mt-4 crop-we-section">                                
                
                                <div class="">
                                    <table class="table order-ofsale-tbl ink_section" id="link_section">
                                        <tr>
                                            <th>Ex Estate</th>
                                            <th>LG Large Leaf/Semi Leafy/LG Small Leaf/BOPIA/Premium</th>
                                            <th>High & Medium/Off Grade/Dust</th>
                                        </tr>
                                       
                                        @if (count($orderOfSaleDetails) > 0)
                                            @foreach ($orderOfSaleDetails as $singleDetail)
                                                <tr class="add-link">
                                                    <td>            
                                                        <div class="orderof_div" id="add-link">
                                                            <select name="column_1_data[]" class="form-control" >
                                                                <option value="0" disabled>Select Vendor</option>
                                                                @foreach ($vendors as $singleVendor)
                                                                    <option <?php echo ($singleVendor->id == $singleDetail->column_1_details) ? 'selected':'' ?> value="{{$singleVendor->id}}">{{$singleVendor->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                    
                                                    <td>
                                                        <select name="column_2_data[]" class="form-control" id="" >
                                                            <option value="0" disabled>Select Vendor</option>
                                                            @foreach ($vendors as $singleVendor)
                                                                <option <?php echo ($singleVendor->id == $singleDetail->column_2_details) ? 'selected':'' ?> value="{{$singleVendor->id}}">{{$singleVendor->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                    
                                                    <td>
                                                        <select name="column_3_data[]" class="form-control" id="" >
                                                            <option value="0" disabled>Select Vendor</option>
                                                            @foreach ($vendors as $singleVendor)
                                                                <option <?php echo ($singleVendor->id == $singleDetail->column_3_details) ? 'selected':'' ?> value="{{$singleVendor->id}}">{{$singleVendor->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>  
                                                </tr>  
                                            @endforeach  
                                        @else
                                            @for ($i = 0; $i < count($vendors); $i++)
                                                <tr class="add-link">
                                                    <td>            
                                                        <div class="orderof_div" id="add-link">
                                                            <select name="column_1_data[]" class="form-control" >
                                                                <option value="0" disabled selected>Select Vendor</option>
                                                                @foreach ($vendors as $singleVendor)
                                                                    <option value="{{$singleVendor->id}}">{{$singleVendor->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                    
                                                    <td>
                                                        <select name="column_2_data[]" class="form-control" id="" >
                                                            <option value="0" disabled selected>Select Vendor</option>
                                                            @foreach ($vendors as $singleVendor)
                                                                <option value="{{$singleVendor->id}}">{{$singleVendor->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                    
                                                    <td>
                                                        <select name="column_3_data[]" class="form-control" id="" >
                                                            <option value="0" disabled selected>Select Vendor</option>
                                                            @foreach ($vendors as $singleVendor)
                                                                <option value="{{$singleVendor->id}}">{{$singleVendor->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>  
                                                </tr> 
                                            @endfor
                                        @endif                                                                             
                                    </table>


                                    <div class="col-12 mt-5">
                                        <div class="row">
                                            <div class="col-md-6">
                                            </div>                        
                                            <div class="col-md-6 d-flex justify-content-end">
                                                <button class="btn btn-success form-btn-submit" data-submitAfter="save"> SAVE </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div>
                    <div class="row">
                        <div class="col-md-12 crop-we-section">
                            <form id="reportForm" data-action-after=2 data-validate=true method="POST" action="/manipulateAwaitingLotsQtyDetails">
                                @csrf
                                <div class="row mb-20 mt-20">
                                    <div class="col-md-12">
                                        <h1 class="header-font1">Auction Details</h1>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-5">
                                    <label class="label-font mr-12">Scheduled For</label>
                                    <input type="date" class="form-control input-text1" name="sale_scheduled_date" value="{{$saleReportDay_1}}" placeholder="Date">
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
                                            {{-- <input type="text" class="form-control input-text1" name="sale_code" value="{{$awaiting_sale_code}}" readonly placeholder="Sale Code">
                                            <input type="hidden" name="sale_no" value="{{$num}}">
                                            <input type="date" class="form-control input-text1" name="sale_scheduled_date" value="{{$saleReportDay_1}}" placeholder="Date"> --}}
                                            <input type="hidden" class="form-control input-text1" name="sale_code" value="CURRENT_SALE">
                                            <button class="btn btn-success form-btn-submit" data-submitAfter="save"> SAVE </button>
                                        </div>
                                    </div>                                        
                                </div>                                       

                            </form>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">                   
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="header-font1">Settlement Dates</h1>
                        </div>
                    </div>   

                    
                    <form id="reportForm" data-action-after=2 data-validate=true method="POST" action="/manipilateSettlemetDates">
                        @csrf
                        <div>                  
                            <div class="row mt-3">
                                <div class="col-md-12 crop-we-section">
                                    <div class="row">
                                    </div>
                                    <?php
                                        $sttleArray = array();
                                        $qualityDetail = array();
                                        if (count($settlements) > 0 ) {
                                            foreach ($settlements as $key => $value) {
                                                if ($value->type == 'DATE_SETTLEMENT') {                 
                                                    array_push($sttleArray,array(
                                                        'id'=>$value->id,
                                                        'type'=>$value->type,
                                                        'sale_code'=>$value->sale_code,
                                                        'date'=>date('Y-m-d',strtotime($value->date)),
                                                        'small_desc'=>$value->small_desc
                                                    ));
                                                }
                                                
                                                if ($value->type == 'TITLE') {
                                                    $qualityDetail = [
                                                        'id'=>$value->id,
                                                        'type'=>$value->type,
                                                        'sale_code'=>$value->sale_code,
                                                        'date'=>date('Y-m-d',strtotime($value->date)),
                                                        'small_desc'=>$value->small_desc
                                                    ];
                                                }
                                            }  
                                        }                                                                                          
                                    ?>

                                    @if (count($settlements) > 0 )
                                        <div class="row">
                                            @foreach ($sttleArray as $key => $singleSettlement)
                                                <div class="col-md-4">
                                                    <input type="date" name="settle_date_{{$key+1}}" class="form-control" value="{{$singleSettlement['date']}}" style="margin-bottom: 10px !important" id="">
                                                    <input class="form-control" name="settle_txt_{{$key+1}}" id="inputAddress" placeholder="" value="{{$singleSettlement['small_desc']}}">
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="date" name="settle_date_1" class="form-control" style="margin-bottom: 10px !important" id="">
                                                <input class="form-control" name="settle_txt_1" id="inputAddress" value="10% Payment">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="date" name="settle_date_2" class="form-control" style="margin-bottom: 10px !important" id="">
                                                <input type="text" name="settle_txt_2" class="form-control" value="Buyers Prompt">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="date" name="settle_date_3" class="form-control" style="margin-bottom: 10px !important" id="">
                                                <input type="text" name="settle_txt_3" class="form-control" value="Sellers Prompt">
                                            </div>
                                        </div>
                                    @endif
                                                    
                                    
                                    @if (count($settlements) > 0 )
                                        <div class="row mt-3" id="">
                                            <div class="col-md-12">
                                                <h6><b>Quality</b></h6>
                                                <textarea class="form-control" name="small_desc" id="" rows="3">{{$qualityDetail['small_desc']}}</textarea>
                                                <small class="text-danger">Use not more than <b>30</b> words</small>     
                                            </div>
                                        </div>
                                    @else
                                        <div class="row mt-3" id="">
                                            <div class="col-md-12">
                                                <h6><b>Quality</b></h6>
                                                <textarea class="form-control" name="small_desc" id="" rows="3"></textarea>
                                                <small class="text-danger">Use not more than <b>30</b> words</small>  
                                            </div>
                                        </div>
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                        
                        @include('_GeneralComponents.formBottomButtons', ['previous'=>'/auction-descriptions', 'next'=> '/crop-and-weather'])
                    </form>                  
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="{{ asset('assets/js/form/calculations/awaitingSales.js') }}"></script>