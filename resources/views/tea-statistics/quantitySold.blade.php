@extends('theme.partials.home')

@section('content')

    <!-- Container-fluid starts-->
    <div class="page-body">

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="container-fluid">

                    <form id="reportForm" data-action-after=2 data-validate=true method="POST" action="/manipulateQuantitySold">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-40">
                                <h1 class="header-font1">Quantity Sold</h1>
                                <h6>For the sale of {{$formedDate}} 2021</h6>
                            </div>
                        </div>
                        
                        <div class="comment-first-section">    
                            <div>
                                <div class="col-md-4 mb-5">
                                    <small>Select Date</small>
                                    <input type="date" name="quantitySoldDate" value="{{$detailsArray['date']}}" class="form-control" id="">
                                </div>
                            </div>                         
                            <div class="row">
                                <table class="table">
                                    <tr>
                                        <td class=""></td>
                                        <td class="">Weekly (KGS)</td>
                                        <td class="">Todate (KGS)</td>
                                    </tr>

                                    <tr>
                                        <td>
                                        </td>
                                        <td class="">
                                            {{$fetchsalesDetails->year}}
                                        </td>
                                        <td class="">
                                            {{$fetchsalesDetails->year}}
                                        </td>
                                    </tr>
                                    
                                    @foreach ($detailsArray['dataset'] as $key => $singleRow)
                                        @if ($singleRow['type'] == 'TOTAL')
                                        
                                            <tr class="bg-dark-green">
                                                <td class="text-white">
                                                    {{$singleRow['name']}}
                                                </td>
                                                <td class="">
                                                    <input type="text" name="row_value[]" readonly value="{{$singleRow['weekly_price_kgs']}}" id="totalValue" class="form-control">
                                                    <input type="hidden" name="type[]" value="{{$singleRow['type']}}">
                                                </td>
                                                <td class="">
                                                    <input type="text" name="row_value_todate[]" readonly value="{{$singleRow['todate_price_kgs']}}" id="totalTodateValue" class="form-control">
                                                </td>
                                            </tr>                                            
                                        @elseif($singleRow['type'] == 'BMF')
                                            <tr>
                                                <td>
                                                    {{$singleRow['name']}}
                                                </td>
                                                <td>
                                                    <input type="text" name="row_value[]" value="{{$singleRow['weekly_price_kgs']}}" class="form-control">
                                                    <input type="hidden" name="type[]" value="{{$singleRow['type']}}">
                                                </td>
                                                <td>
                                                    <input type="text" name="row_value_todate[]" value="{{$singleRow['todate_price_kgs']}}" class="form-control">
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td class="">
                                                    {{$singleRow['name']}}
                                                </td>
                                                <td class="">
                                                    <input type="text" name="row_value[]" value="{{$singleRow['weekly_price_kgs']}}" onkeyup="calculateTotal(this)" id="rowVal" class="form-control td-value">
                                                    <input type="hidden" name="type[]" value="{{$singleRow['type']}}">
                                                </td>
                                                <td class="">
                                                    <input type="text" name="row_value_todate[]" value="{{$singleRow['todate_price_kgs']}}" id="" onkeyup="calculateTodateTotal(this)" class="form-control td-todate-value">
                                                </td>
                                            </tr>
                                        @endif                                       
                                    @endforeach                 
                                </table>
                            </div>
                        </div> 

                        @include('_GeneralComponents.formBottomButtons', ['previous'=>'/top-prices', 'next'=> '/rates-of-exchange'])

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('page-js')
    <script src="{{ asset('assets/js/form/calculations/quantitySold.js') }}"></script>
@endsection