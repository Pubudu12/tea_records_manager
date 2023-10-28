@extends('theme.partials.home')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
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
                                $num++;
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
                                        </div> 
                                        
                                        <div class="col-12 mt-5">
                                            <div class="row">                                        
                                                <div class="col-md-12 d-flex justify-content-end">
                                                    <button class="btn btn-success form-btn-submit" data-submitAfter="save"> SAVE </button>
                                                </div>
                                            </div>                                        
                                        </div>
                                    </form>


                                    <form id="reportForm1" class="mt-5" data-action-after=2 data-validate=true method="POST" action="/manipulateAwaitingtimeSlot">
                                        @csrf
                                        <div class="row table-cell-light-blue2 bg-package">
                                            <div class="col-md-12">
                                                <p class="tblSubTtl mt-40">Approximate Selling Time</p>

                                                @if (count($awaitingSaleTimeSlots) > 0 )   
                                                    <?php 
                                                        $day1 = date('Y-m-d');      
                                                        $day2 = date('Y-m-d');      
                                                    ?>                   
                                                    
                                                    @foreach ($awaitingSaleTimeSlots as $singleTimeSlot)
                                                        @if ($singleTimeSlot->type == 'DAY_1')
                                                           <?php $day1 = date('Y-m-d',strtotime($singleTimeSlot->date))  ?>
                                                        @endif   
                                                        @if ($singleTimeSlot->type == 'DAY_2')
                                                            <?php     
                                                                $day2 = date('Y-m-d',strtotime($singleTimeSlot->date)) ?>
                                                        @endif                                                              
                                                    @endforeach 


                                                    <div class="row mt-3">
                                                        <div class="col-md-6">
                                                            <label for="">Date</label>

                                                            @if ($awaitingSaleTimeSlots[0]->type == 'DAY_1')
                                                                <input type="date" class="form-control" name="approx_time_day_one" value="{{$day1}}">                                                        
                                                            @endif   

                                                            @foreach ($awaitingSaleTimeSlots as $singleTimeSlot)
                                                                @if ($singleTimeSlot->type == 'DAY_1')
                                                                    <div id="time_slot_outer1">
                                                                        <div class="d-flex mt-3 justify-content-between" id="day_one_time_slots-1">
                                                                            <input type="text" class="form-control" name="day_one_elevation[]" value="{{$singleTimeSlot->elevation}}" placeholder="Elevation"> &nbsp;&nbsp; 
                                                                            <input type="text" class="form-control timepicker" name="day_one_time[]" placeholder="Time" value="{{$singleTimeSlot->time}}">
                                                                            {{-- <button class="btn remove-btn-1" type="button" id="removeLink" onclick="removeTimeSlots1(this)"><i class="fa fa-trash"></i></button> --}}
                                                                        </div>
                                                                    </div>
                                                                @endif                                                                
                                                            @endforeach                                                                
                                                            
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label for="">Date</label>
                                                            <input type="date" class="form-control" name="approx_time_day_two" value="{{$day2}}" id="">
                                                                {{-- @for ($i = 0; $i < 6; $i++) --}}
                                                                    @foreach ($awaitingSaleTimeSlots as $singleTimeSlot)
                                                                        @if ($singleTimeSlot->type == 'DAY_2')
                                                                            <div id="outer2-time_slot">
                                                                                <div class="d-flex mt-3 justify-content-between" id="day_two_time_slots-2">
                                                                                    <input type="text" class="form-control" name="day_two_elevation[]" value="{{$singleTimeSlot->elevation}}" placeholder="Elevation"> &nbsp;&nbsp; 
                                                                                    <input type="text" class="form-control timepicker" name="day_two_time[]" value="{{$singleTimeSlot->time}}" placeholder="Time">
                                                                                    {{-- <button class="btn remove-btn-1" type="button" id="removeLink" onclick="removeTimeSlots_2(this)"><i class="fa fa-trash"></i></button> --}}
                                                                                </div>
                                                                            </div>   
                                                                        @endif                                                            
                                                                    @endforeach
                                                                {{-- @endfor --}}
                                                        </div>
                                                    </div>  
                                                @else
                                                    <div class="row mt-3">
                                                        <div class="col-md-6">
                                                            <label for="">Date</label>
                                                            <input type="date" class="form-control" name="approx_time_day_one" value="">

                                                            @for ($i = 0; $i < 6; $i++)
                                                                <div id="time_slot_outer1">
                                                                    <div class="d-flex mt-3 justify-content-between" id="day_one_time_slots-1">
                                                                        <input type="text" class="form-control" name="day_one_elevation[]" placeholder="Elevation"> &nbsp;&nbsp; 
                                                                        <input type="text" class="form-control timepicker" name="day_one_time[]" placeholder="Time">
                                                                        {{-- <button class="btn remove-btn-1" type="button" id="removeLink" onclick="removeTimeSlots1(this)"><i class="fa fa-trash"></i></button> --}}
                                                                    </div>
                                                                </div>
                                                            @endfor  
                                                            {{-- <div class="col-md-12">
                                                                <button type="button" class="btn sm-add" onclick="addTimeSlotLink1()" id="add_link_btn"><i class="fa fa-plus"></i></button>
                                                            </div> --}}
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label for="">Date</label>
                                                            <input type="date" class="form-control" name="approx_time_day_two" value="" id="">

                                                            @for ($i = 0; $i < 6; $i++)
                                                            <div id="outer2-time_slot">
                                                                <div class="d-flex mt-3 justify-content-between" id="day_two_time_slots-2">
                                                                    <input type="text" class="form-control" name="day_two_elevation[]" placeholder="Elevation"> &nbsp;&nbsp; 
                                                                    <input type="text" class="form-control timepicker" name="day_two_time[]" placeholder="Time">
                                                                    {{-- <button class="btn remove-btn-1" type="button" id="removeLink" onclick="removeTimeSlots_2(this)"><i class="fa fa-trash"></i></button> --}}
                                                                </div>
                                                            </div>   
                                                            @endfor  
                                                            {{-- <div class="col-md-12">
                                                                <button type="button" class="btn sm-add" onclick="addTimeSlotLink2()" id="add_link_btn"><i class="fa fa-plus"></i></button>
                                                            </div> --}}
                                                            
                                                        </div>
                                                    </div>  
                                                @endif

                                            </div>
                                        </div>  
                                        <input type="hidden" name="awaiting_sale_code" value="{{$awaiting_sale_code}}">
                                        
                                        @include('_GeneralComponents.formDefaultSubmitButton')
                                        
                                    </form>
                                    

                                    <div class="row mt-5">
                                        <form id="reportForm" data-action-after=2 data-validate=true method="POST" action="/manipulateOrderOfSale">
                                            @csrf
                                            <div class="mt-2">                  
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h1 class="header-font1">Order of Sales</h1>
                                                    </div>
                        
                                                    <div class="col-md-12 mt-4 crop-w-section">                                
                                        
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
                                                                    <input type="hidden" name="awaiting_sale_code" value="{{$awaiting_sale_code}}">      
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
                                    </div>

                                </div>
                            </div>                 
                        </div>

                        @include('_GeneralComponents.formBottomNextPrevOnly', ['previous'=>'/world-tea-production', 'next'=> '/awaitingSales2'])
                        {{-- /world-tea-production --}}
                    </div>                
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('page-js')
    <script src="{{ asset('assets/js/form/calculations/awaitingSales.js') }}"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

    <script>        
        $('.timepicker').timepicker({
            timeFormat: 'h:mm p',
            interval: 60,
            minTime: '8',
            maxTime: '6:00pm',
            defaultTime: '',
            startTime: '08:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
    </script>
@endsection

