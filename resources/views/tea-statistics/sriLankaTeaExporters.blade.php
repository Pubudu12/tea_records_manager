<?php
use App\Http\Controllers\General\DefaultFunctions;
?>
@extends('theme.partials.home')

@section('content')

    <!-- Container-fluid starts-->
    <div class="page-body">

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="container-fluid">

                    <form id="reportForm" data-action-after=2 data-validate=true method="POST" action="/manipulateTeaExports">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-40">
                                <h1 class="header-font1">Sri Lanka Tea Exports</h1>
                            </div>
                        </div> 
                        
                        
                        <div class="comment-first-section">    
                            {{-- <div class="row mb-4">
                                <div class="col-md-5">
                                    <h4>Date</h4>
                                    <input type="date" name="exportDate" value="{{$exportDetails['date']}}" class="form-control">
                                </div>
                            </div>   --}}
                            <div class="row mt-1 pb-4">
                                <div class="col-md-3">
                                    <label class="mt-4">Year</label>
                                    <select name="year" class="form-control">
                                        <option value="0" disabled>Select Year</option>
                                        @foreach ($years as $singleyear)
                                            <option value="{{$singleyear}}"  {{ DefaultFunctions::comboBoxSelected( $singleyear, '2022') }}>{{$singleyear}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="mt-4">Month</label>
                                    <select name="month" class="form-control">
                                        <option value="0" disabled>Select Month</option>
                                        @foreach ($months as $singlemonth)
                                            <option value="{{$singlemonth->id}}" {{($singlemonth->id == '6') ? 'selected': ''}}>{{$singlemonth->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row pt-4">
                                <table class="table" id="link_section">
                                    <tr>
                                        <td>Description</td>
                                        <td class="text-center">Quantity</td>
                                        <td class="text-right bg-dark-green text-white text-center">Approx FOB per KG (LKR)</td>
                                        <td class="text-right"> Approx FOB per KG (USD)</td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td class="bg-dark-green text-white"></td>
                                        <td></td>
                                    </tr>

                                    @foreach ($exportDetails['detalis'] as $singleExport)
                                        <tr>
                                            @if ($singleExport['type'] == "TOTAL")
                                                <td><b>{{$singleExport['ref_name']}}</b></td>
                                            @else
                                                <td>{{$singleExport['ref_name']}}</td>
                                            @endif
                                            
                                            <td>
                                                <input class="form-control {{($singleExport['type'] == "TOTAL") ? 'totVPrice' : 'VPrice'}}" name="v_price[]" placeholder="Quantity" value="{{$singleExport['v_price']}}" onkeyup="calculateVPrice()">
                                            </td>
                                            <td class="text-right bg-dark-green text-white">
                                                <input class="form-control {{($singleExport['type'] == "TOTAL") ? 'totValuePrice' : 'valuePrice'}}" name="value_price[]" placeholder="Approx FOB per KG (LKR)" value="{{$singleExport['value_price']}}" onkeyup="calculateValuePrice()">
                                            </td>
                                            <td class="text-right">
                                                <input class="form-control {{($singleExport['type'] == "TOTAL") ? 'totApproxPrice' : 'approxPrice'}}" name="approx_price[]" placeholder=" Approx FOB per KG (USD)" value="{{$singleExport['approx_price']}}" onkeyup="calculateApproxPrice()">
                                            </td>
                                            <input type="hidden" name="ref_id[]" value="{{$singleExport['id']}}">
                                        </tr>
                                    @endforeach
                                </table>                                
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-8">
                                    <label for="">Source</label>
                                    @if ($exportDetails['main_id'] == 0)
                                        <input type="text" class="form-control" name="source">
                                        <input type="hidden" name="main_id" value="0">
                                    @else
                                        <input type="text" class="form-control" value="{{$exportDetails['source']}}" name="source">
                                        <input type="hidden" name="main_id" value="{{$exportDetails['main_id']}}">
                                    @endif
                                </div>
                            </div>
                        </div>    

                        @include('_GeneralComponents.formBottomButtons', ['previous'=>'/national-tea-exports', 'next'=> '/major-importers'])

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('page-js')
    <script src="{{ asset('assets/js/form/calculations/sriLankaTeaExports.js') }}"></script>
@endsection