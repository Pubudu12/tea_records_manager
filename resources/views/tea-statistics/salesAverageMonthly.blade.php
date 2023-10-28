@extends('theme.partials.home')

@section('content')

    <!-- Container-fluid starts-->
    <div class="page-body">

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="container-fluid">                    
                    <form id="reportForm" data-action-after=2 data-validate=true method="POST" action="/manipulatePublicSale">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <h1 class="header-font1">Public Auction/Gross Sales Average for the month of {{$month}} {{$year}}</h1>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-12 mb-40">
                                <div class="d-flex"><h3 class="h3-custom l-green">{{$sale_code}} </h3> <h6 class="mt-1">  </h6> </div><!--| 15TH / 16TH DECEMBER 2020-->
                                <input type="hidden" name="previous_sale_code" value="{{$sale_code}}">
                                <input type="hidden" name="sale_type" value="MONTHLY">
                            </div>
                        </div>
                        
                        
                        <div class="comment-first-section">                            
                            <div class="row">
                                <table class="table" id="link_section">
                                    <tr>
                                        <td></td>
                                        <td class="text-center" colspan="2">Monthly (LKR)</td>
                                        <td class="text-center" colspan="2">Todate (LKR)</td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td class="text-center">{{$currentYear}}</td>
                                        <td class="text-center">{{$lastYear}}</td>
                                        <td class="text-center">{{$currentYear}}</td>
                                        <td class="text-center">{{$lastYear}}</td>
                                    </tr>

                                    @foreach ($values as $key => $singleValue)
                                        <tr>
                                            @if ($singleValue['type'] == 'TOTAL')
                                                <td><b>{{$singleValue['name']}}</b></td>
                                            @else
                                                <td>{{$singleValue['name']}}</td>
                                            @endif
                                            <input type="hidden" name="reference[]" value="{{$singleValue['id']}}">
                                            
                                            <td class="text-center table-cell-light-blue">
                                                <input type="text" class="form-control" name="value[]" class="text-center" placeholder="Value" value="{{$singleValue['price_lkr']}}">
                                            </td>   
                                            <td class="text-center">
                                                <input type="text" class="form-control" readonly class="text-center" tabindex="-1" placeholder="Value" value="{{$singleValue['lastYear_price_lkr']}}">
                                            </td>      
                                            <td class="text-center table-cell-light-blue">
                                                <input type="text" class="form-control" name="todate_value[]" value="{{$singleValue['todate_price_lkr']}}" placeholder="Value" class="text-center">
                                            </td> 
                                            <td class="text-center">
                                                <input type="text" class="form-control" readonly tabindex="-1" value="{{$singleValue['lastYear_todate_price_lkr']}}" placeholder="Value" class="text-center">
                                            </td>                                                          
                                        </tr> 
                                    @endforeach   
                                </table>
                                <div class="row mt-5">
                                    <div class="col-md-6">                                            
                                        <label for="">Source</label>
                                        @if ($status == 1)
                                            <input type="text" class="form-control" placeholder="Source" value="{{$source_1}}" name="source_1">
                                        @else
                                            <input type="text" class="form-control" placeholder="Source" name="source_1">
                                        @endif
                                    </div>

                                    <div class="col-md-6">                                            
                                        <label for="">Source</label>
                                        @if ($status == 1)
                                            <input type="text" class="form-control" placeholder="Source" value="{{$source_2}}" name="source_2">
                                        @else
                                            <input type="text" class="form-control" value="{{$source_2}}" placeholder="Source" name="source_2">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>     
                        
                        @include('_GeneralComponents.formBottomButtons', ['previous'=>'/weekly-tea-sales-average', 'next'=> '/national-tea-production'])

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection