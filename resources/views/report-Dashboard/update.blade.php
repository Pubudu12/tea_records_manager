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
                        <div class="col-md-8 home-indx">
                            <h1>Update New Report</h1>
                            <p>Welcome to the F&W Marketing Report Generator</p>
                        </div>
                    </div>

                    <div class="mt-3">
                        <form
                            id="reportForm-first"
                            data-validate=true
                            method="POST"
                            action="/updateSaleReport">
                            @csrf

                            <div class="comment-first-section">
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <label for="">Report Title</label>
                                        <input class="form-control input-text1" name="title" id="" value="{{$salesDetails->title}}" placeholder="Title">

                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label class="mt-4" for="">Year</label>
                                                <select name="year" class="form-control">
                                                    <option value="0" disabled>Select Year</option>
                                                    @foreach ($yearList as $year)
                                                        <option value="{{$year}}"  {{ DefaultFunctions::comboBoxSelected( $year, $salesDetails->year) }}>{{$year}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="mt-4" for="">Month</label>
                                                <select name="month" class="form-control">
                                                    <option value="0" disabled>Select Month</option>
                                                    @foreach ($monthList as $month)
                                                        <option value="{{$month->id}}" {{($month->id == $salesDetails->month) ? 'selected': ''}}>{{$month->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label class="mt-4" for="">Sales Number</label>
                                                <input class="form-control input-text1" name="sale_number" value="{{$salesDetails->sales_no}}" placeholder="Sale Number" id="" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="mt-4" for="">Publish Date</label>
                                                <input class="form-control input-text1" type="date" name="publish_date" value="{{date('Y-m-d',strtotime($salesDetails->published_date))}}" placeholder="Publish Date" id="">
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label class="mt-4" for="">Auction Date 1</label>
                                                <input class="form-control input-text1" name="report_day_one" value="{{date('Y-m-d',strtotime($salesDetails->report_day_one))}}" type="date" id="">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="mt-4" for="">Auction Date 2</label>
                                                @if ($salesDetails->report_day_two == NULL)
                                                    <input class="form-control input-text1" name="report_day_two" value="" type="date" id="">
                                                @else
                                                    <input class="form-control input-text1" name="report_day_two" value="{{date('Y-m-d',strtotime($salesDetails->report_day_two))}}" type="date" id="">                                                    
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mt-5" style="padding-top:30px">
                                            <div class="col-md-6">
                                                <h5 class="font-green"><b>Current Dollar Value</b></h5>
                                                @if ($salesDetails->current_dollar_value == NULL | $salesDetails->current_dollar_value == 0)
                                                    <input type="number" class="form-control" name="current_dollar_value" value="{{$salesDetails->current_dollar_value}}">                                                    
                                                @else
                                                    <input type="number" class="form-control" name="current_dollar_value" readonly value="{{$salesDetails->current_dollar_value}}">                                                    
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-2"></div>
                                </div>

                                <input type="hidden" name="sale_id" value="{{$salesDetails->sales_id}}">
                                @include('_GeneralComponents.formBottomButtons', ['previous'=>'/dashboard', 'next'=> '/reportDashboard'])

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection


@section('page-js')

<script src="{{ asset('assets/js/validations/report.js') }}"></script>

@endsection
