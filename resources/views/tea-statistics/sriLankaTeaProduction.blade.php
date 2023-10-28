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
                    <form id="reportForm" data-action-after=2 data-validate=true method="POST" action="/manipulateSriLankanTeaProduction">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-40">
                                <h1 class="header-font1">Sri Lanka Tea Production (M/KGS)</h1>
                            </div>
                        </div>                       
           
                        
                        <div class="comment-first-section">  
                            <div class="row mt-1 pb-4">
                                <div class="col-md-3">
                                    <label class="mt-4">Year</label>
                                    <select name="year" class="form-control">
                                        <option value="0" disabled>Select Year</option>
                                        @foreach ($yearList as $singleyear)
                                            <option value="{{$singleyear}}"  {{ DefaultFunctions::comboBoxSelected( $singleyear, $year) }}>{{$singleyear}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="mt-4">Month</label>
                                    <select name="month" class="form-control">
                                        <option value="0" disabled>Select Month</option>
                                        @foreach ($monthList as $singlemonth)
                                            <option value="{{$singlemonth->id}}" {{($singlemonth->id == $month) ? 'selected': ''}}>{{$singlemonth->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- <h5><b>February 2021</b></h5>    --}}
                            <div class="row mt-5">
                                <table class="table" id="link_section">                                    
                                    <tr>
                                        <td><b>Elevation</b></td>
                                        <td class="text-center" colspan="2"><b>CTC</b></td>
                                        <td class="text-center dark-yellow-cell" colspan="2"><b>Change {{$compareYears}}</b></td>
                                        <td class="text-center" colspan="2"><b>Orthodox</b></td>
                                        <td class="text-center dark-yellow-cell" colspan="2"><b>Change {{$compareYears}}</b></td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td class="text-center">
                                            {{$year}}
                                        </td>
                                        <td class="text-center">
                                            {{$lastYear}}
                                        </td>
                                        <td class="text-center dark-yellow-cell">
                                            Actual
                                        </td>
                                        <td class="text-center dark-yellow-cell">
                                           %
                                        </td>
                                        <td class="text-center">
                                            {{$currentYear}}
                                        </td>
                                        <td class="text-center">
                                            {{$lastYear}}
                                        </td>
                                        <td class="text-center dark-yellow-cell">
                                            Actual
                                        </td>
                                        <td class="text-center dark-yellow-cell">
                                           %
                                        </td>
                                    </tr>

                                    @foreach ($details as $singleDetail)
                                        <tr>
                                            @if ($singleDetail['type'] == 'TOTAL')
                                                <td><b>{{$singleDetail['name']}}</b></td>
                                            @else
                                                <td>{{$singleDetail['name']}}</td>
                                            @endif
                                            
                                            <input type="hidden" name="ref_id[]" value="{{$singleDetail['id']}}">
                                            <td class="text-center">
                                                <input type="text" class="form-control {{($singleDetail['type'] == 'TOTAL') ? 'totctc' : 'ctc-value'}}" name="ctc_price[]" placeholder="Value" value="{{$singleDetail['ctc_price']}}" onkeyup="calculateCTCTotal(this)">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="" placeholder="Value" readonly value="{{$singleDetail['lastYear_ctc_price']}}">
                                            </td>
                                            <td class="text-center dark-yellow-cell">
                                                <input type="text" class="form-control {{($singleDetail['type'] == 'TOTAL') ? 'totctc_ch_act' : 'ctc_ch_act_value'}}" name="ctc_change_actual_price[]" value="{{$singleDetail['ctc_change_actual_price']}}" onkeyup="calculateCTCActutalTotal(this)" placeholder="Value">
                                                
                                            </td>
                                            <td class="text-center dark-yellow-cell">
                                                <input type="text" class="form-control {{($singleDetail['type'] == 'TOTAL') ? 'totctc_ch_perc' : 'ctc_ch_perc_value'}}" name="ctc_change_percent_price[]" value="{{$singleDetail['ctc_change_percent_price']}}" onkeyup="calculateCTCPercentTotal(this)" placeholder="Value">
                                                
                                            </td>
                                            <td class="text-center">
                                                <input type="text" class="form-control {{($singleDetail['type'] == 'TOTAL') ? 'tot_orth' : 'orth_value'}}" placeholder="Value" name="orthodox_price[]" value="{{$singleDetail['orthodox_price']}}" onkeyup="calculateOrthTotal(this)">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="" placeholder="Value" readonly value="{{$singleDetail['lastYear_orthodox_price']}}">
                                            </td>
                                            <td class="text-center dark-yellow-cell">
                                                <input type="text" class="form-control {{($singleDetail['type'] == 'TOTAL') ? 'tot_orth_ch_act' : 'orth_ch_act_value'}}" placeholder="Value" name="orthodox_change_actual_price[]" value="{{$singleDetail['orthodox_change_actual_price']}}" onkeyup="calculateOrthActualTotal(this)">
                                                
                                            </td>
                                            <td class="text-center dark-yellow-cell">
                                                <input type="text" class="form-control {{($singleDetail['type'] == 'TOTAL') ? 'tot_orth_ch_perc' : 'orth_ch_perc_value'}}" placeholder="Value" name="orthodox_change_percent_price[]" value="{{$singleDetail['orthodox_change_percent_price']}}" onkeyup="calculateOrthPercentTotal(this)">
                                                
                                            </td>
                                        </tr>
                                    @endforeach                                    
                                </table>
                            </div>
                        </div> 

                        <input type="hidden" name="currentYear" value="{{$currentYear}}">
                        <input type="hidden" name="lastYear" value="{{$lastYear}}">

                        @include('_GeneralComponents.formBottomButtons', ['previous'=>'/national-tea-production', 'next'=> '/national-tea-exports'])
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('page-js')
    <script src="{{ asset('assets/js/form/calculations/SriLankaTeaProduction.js') }}"></script>
@endsection