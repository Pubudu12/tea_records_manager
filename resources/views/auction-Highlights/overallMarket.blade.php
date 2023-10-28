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

                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="header-font1">Overall Market</h1>
                        </div>
                    </div>

                    <form id="reportForm1" data-action-after=2 data-validate=true method="POST" action="/manipulateOverallMarket">
                        @csrf
                        <div class="row mt-4">
                            <div class="col-md-12 crop-we-section">
                                <!-- <h3 class="sub-sub-ttl">Order of Sale</h3> -->
                                <div class="ink_section1" id="link_section1">
                                    <table class="table summary-tbl add-link1" id="add-link1">
                                        <tr>
                                            <th></th>
                                            <th class="text-center">QTY ( M/KGS )</th>
                                            <th class="text-center">Demand</th>
                                        </tr>

                                        @if (count($fetchOverallMarketDetails) != 0)
                                            @foreach ($fetchOverallMarketDetails as $key => $overallSingle)
                                                <tr>
                                                    <td>
                                                        <div class="text-right" name="ref-name" value="">{{$overallSingle->refName}}</div>
                                                    </td>
                                                    <td class="text-center">
                                                        <input class="form-control text-center" name="overall_markrt_qty[]" value="{{($overallSingle->quantity_m_kgs != NULL) ? number_format($overallSingle->quantity_m_kgs,2) : ''}}" required placeholder="Quantity">
                                                    </td>
                                                    <td>
                                                        <input class="form-control text-center" name="overall_demand[]" value="{{$overallSingle->demand}}" required placeholder="Demand">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            @foreach ($references as $reference)
                                                <tr>
                                                    <td>
                                                        <div class="text-center" name="ref-name" value="">{{$reference->name}}</div>
                                                    </td>
                                                    <td class="text-center">
                                                        <input class="form-control text-center" name="overall_markrt_qty[]" required placeholder="Quantity">
                                                    </td>
                                                    <td>
                                                        <input class="form-control text-center" name="overall_demand[]" required placeholder="Demand">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </table>
                                </div>

                                @include('_GeneralComponents.formDefaultSubmitButton')

                            </div>
                        </div>
                    </form>

                    <form id="reportForm" data-action-after=2 data-validate=true method="POST" action="/manipulateOverallDetails">
                        @csrf
                        <div>
                            <div class="row">
                                <div class="col-md-12 crop-we-section">
                                    <div class="ink_section1" id="link_section1">
                                        <table class="max-w-100 table table-hover summary-tbl">

                                            @foreach ($overallElevationRefs as $mainKey => $singleRef)
                                                <tr>
                                                    <td class="{{$singleRef['class']}} pt-3">
                                                        {{$singleRef['name']}}
                                                        <input type="hidden" name="elevation_name[]" value="{{$singleRef['code']}}">
                                                    </td>

                                                    @if (($singleRef['level'] == 1) | ($singleRef['level'] == 2))
                                                        @if ($singleRef['columns'] != NULL)
                                                            @foreach ($singleRef['columns'] as $singleColumn)
                                                                <td class="text-center clr-grey pt-3">{{$singleColumn}}</td>
                                                                <input type="hidden" name="teaGradeColumns[]" value="{{$singleColumn}}">
                                                            @endforeach
                                                        @endif
                                                    @else
                                                        @foreach ($singleRef['columns'] as $singleColumnKey => $singleColumn)
                                                            <td class="text-center pt-3">
                                                                <div class="inputWitharrow-box">
                                                                    <input class="form-control input-text1 text-center" name="overall_value_{{$mainKey}}[]" placeholder="Value" value="{{$singleColumn}}">

                                                                    <div class="switch-toggle toggle-bg d-flex justify-content-center">
                                                                        <input
                                                                            id="on_{{$mainKey}}{{$singleColumnKey}}"
                                                                            name="state_{{$mainKey}}{{$singleColumnKey}}"
                                                                            {{ DefaultFunctions::IsCompareChecked( '1',  $singleRef['status'][$singleColumnKey]) }}
                                                                            value="1"
                                                                            type="radio" 
                                                                            tabindex="-1"/>
                                                                        <label class="toggle_1" for="on_{{$mainKey}}{{$singleColumnKey}}"><i class="fa fa-arrow-up" aria-hidden="true"></i></label>

                                                                        <input
                                                                            id="off_{{$mainKey}}{{$singleColumnKey}}"
                                                                            name="state_{{$mainKey}}{{$singleColumnKey}}"
                                                                            {{ DefaultFunctions::IsCompareChecked( '0',  $singleRef['status'][$singleColumnKey]) }}
                                                                            value="0"
                                                                            type="radio" 
                                                                            tabindex="-1"/>
                                                                        <label class="toggle_2" for="off_{{$mainKey}}{{$singleColumnKey}}"><i class="fa fa-arrow-down" aria-hidden="true"></i></label>

                                                                        <input
                                                                            id="firm_{{$mainKey}}{{$singleColumnKey}}"
                                                                            name="state_{{$mainKey}}{{$singleColumnKey}}"
                                                                            {{ DefaultFunctions::IsCompareChecked( 'NO',  $singleRef['status'][$singleColumnKey]) }}
                                                                            value="NO" type="radio" tabindex="-1"/>
                                                                        <label class="toggle_3" for="firm_{{$mainKey}}{{$singleColumnKey}}" class="disabled"><i class="fa fa-minus" aria-hidden="true"></i></label>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('_GeneralComponents.formBottomButtons', ['previous'=>'/market-dashboard', 'next'=> '/auction-descriptions'])
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection

@section('page-js')

{{-- <script src="{{ asset('assets/js/validations/auction-highlights/overallMarket.js') }}"></script> --}}

@endsection
