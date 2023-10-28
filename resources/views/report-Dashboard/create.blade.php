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
                            <h1>Create New Report</h1>
                            <p>Welcome to the F&W Marketing Report Generator</p>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <form id="reportForm-first" data-action-after=2 data-validate=true method="POST" action="/createSaleReport">
                                @csrf
                            <div class="comment-first-section">
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <label for="">Report Title</label>
                                        <input class="form-control input-text1" name="title" id="" placeholder="Title ">

                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label class="mt-4" for="">Year</label>
                                                <select name="year" class="form-control" id="">
                                                    <option value="0" disabled>Select Year</option>
                                                    @foreach ($yearList as $year)
                                                        <option value="{{$year}}">{{$year}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="mt-4" for="">Month</label>
                                                <select name="month" class="form-control" id="">
                                                    <option value="0" disabled>Select Month</option>
                                                    @foreach ($monthList as $month)
                                                        <option value="{{$month->id}}">{{$month->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label class="mt-4" for="">Sales Number</label>
                                                <input class="form-control input-text1" name="sale_number" placeholder="Sale Number" id="">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="mt-4" for="">Publish Date</label>
                                                <?php $date = date('Y-m-d');?>
                                                <input class="form-control input-text1" type="date" value="{{date('Y-m-d',strtotime($date))}}" name="publish_date" placeholder="Publish Date" id="">
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label class="mt-4" for="">Auction Day 1</label>
                                                <input class="form-control input-text1" name="report_day_one" type="date" id="">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="mt-4" for="">Auction Day 2</label>
                                                <input class="form-control input-text1" name="report_day_two" type="date" id="">
                                            </div>
                                        </div>
                                        
                                        <div class="row mt-5" style="padding-top:30px">
                                            <div class="col-md-6">
                                                <h5 class="font-green"><b>Current Dollar Value</b></h5>
                                                <input type="number" class="form-control" name="current_dollar_value" id="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2"></div>
                                </div>                                

                                @if (Session::has('sale_code'))
                                    @include('_GeneralComponents.formBottomButtons', ['previous'=>'/dashboard', 'next'=> '/reportDashboard'])
                                @else
                                    @include('_GeneralComponents.formBottomButtons', ['previous'=>'/dashboard', 'next'=> '/report/create'])
                                @endif
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