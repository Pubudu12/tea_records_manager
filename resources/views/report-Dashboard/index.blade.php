@extends('theme.partials.home')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Container-fluid starts-->
    <div class="page-body">

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 home-indx">
                            <h1>Home</h1>
                            <p>Welcome to the F&W Marketing Report Generator</p>
                        </div>
                        {{-- <div class="col-md-6">
                            <p class="text-right">Hello,</p>
                            <h1 class="text-right">Ishani</h1>
                            <p class="address-p text-right">Last logged in 19.30, Wednesday</p>
                            <p class="loging-date-p text-right">04/03/20</p>
                        </div> --}}

                        
                        <div class="col-md-6 mt-5">
                            <a href="/report/create" class="dash-btn next-btn custom-btn-save">CREATE NEW REPORT</a>
                        </div>
                    </div>
                    
                    <div class="comment-first-section mt-5">
                        <table class="dataListTable table" id="dataListTable">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td><b>Title</b></td>
                                    <td><b>Sales Number</b></td>
                                    <td><b>Sale Code</b></td>
                                    <td><b>Sale Date</b></td>
                                    <td><b>Action</b></td>
                                </tr>                                    
                            </thead>
                            <tbody>
                                @foreach ($salesList as $key => $sale)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$sale->title}}</td>
                                        <td>{{$sale->sales_no}}</td>
                                        <td>{{$sale->sales_code}}</td>
                                        <td>{{date('jS F Y',strtotime($sale->report_day_one))}}</td> 
                                        <td>
                                            <a class="btn btn-sm btn-redirect" href="/report/update/{{ $sale->sales_code }}"><i class="fa fa-edit"></i></a>
                                            <a class="btn btn-sm btn-danger" onclick="callDelete(this)" data-sale_code="{{ $sale->sales_code }}" id="report_sales_code"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>      
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
    
@endsection