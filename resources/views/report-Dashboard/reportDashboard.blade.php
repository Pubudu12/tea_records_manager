@extends('theme.partials.home')

@section('content')

    <!-- Container-fluid starts-->
    <div class="page-body">

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="container-fluid">

                    <div class="row">
                        {{-- <div class="col-md-6">
                            <h1>Home</h1>
                            <p>Welcome to the F&W Marketing Report Generator</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-right">Hello,</p>
                            <h1 class="text-right">Ishani</h1>
                            <p class="address-p text-right">Last logged in 19.30, Wednesday</p>
                            <p class="loging-date-p text-right">04/03/20</p>
                        </div> --}}
                    </div>

                    <div>
                        <div class="row home-fill-section">
                           <div class="home-no-div">
                               <a href="/market-dashboard" class="home-box-1 flex-main d-flex align-items-center">
                                    <div class="flex-main d-flex justify-content-center align-items-center flex-column">
                                        <img class="inner-img inner-img-greyscale" src="{{ asset('assets/images/dash_icons/list.png') }}">
                                        <div class="mt-2 text-center card-font-main">
                                            <div class="card-font">Auction Highlights</div>
                                            <small class="float-right">Market Dashboard</small>
                                        </div>
                                    </div>
                                    <div class="home-box-overlay">
                                        <p>1</p>
                                    </div>         
                                </a>
                               <a href="/order-of-sales" class="home-box-1 flex-main d-flex align-items-center">
                                    <div class="flex-main d-flex justify-content-center align-items-center flex-column">
                                        <img class="inner-img inner-img-greyscale" src="{{ asset('assets/images/dash_icons/auction.png') }}">
                                        <div class="mt-2 text-center card-font-main">
                                            <div class="card-font">Colombo Auctions</div>
                                            <small class="float-right">Order of Sales</small>
                                        </div>
                                    </div>
                                    <div class="home-box-overlay">
                                        <p>2</p>
                                    </div>
                                </a>
                                <a href="/qualtity-sold" class="home-box-1 flex-main d-flex align-items-center">
                                    <div class="flex-main d-flex justify-content-center align-items-center flex-column">
                                        <img class="inner-img inner-img-greyscale" src="{{ asset('assets/images/dash_icons/stat.png') }}">
                                        <div class="mt-2 text-center card-font-main">
                                            <div class="card-font">Tea Statistics</div>
                                            <small class="float-right">Quantity Sold</small>
                                        </div>
                                    </div>
                                    <div class="home-box-overlay">
                                        <p>3</p>
                                    </div>
                                </a>
                           </div>
                           <div class="home-no-div2">
                                <a href="/World Tea Descriptions" class="home-box-1 flex-main d-flex align-items-center">
                                    <div class="flex-main d-flex justify-content-center align-items-center flex-column">
                                        <img class="inner-img inner-img-greyscale" src="{{ asset('assets/images/dash_icons/earth.png') }}">
                                        <div class="mt-2 text-center card-font-main">
                                            <div class="card-font">World Tea Auctions</div>
                                            <small class="float-right">World Tea Descriptions</small>
                                        </div>
                                    </div>
                                    <div class="home-box-overlay">
                                        <p>4</p>
                                    </div>
                                </a>
                                <a href="/suppliments" class="home-box-1 flex-main d-flex align-items-center">
                                    <div class="flex-main d-flex justify-content-center align-items-center flex-column">
                                        <img class="inner-img inner-img-greyscale" src="{{ asset('assets/images/dash_icons/desc.png') }}">
                                        <div class="mt-2 text-center card-font-main">
                                            <div class="card-font">Suppliments</div>
                                            <small class="float-right">Suppliments</small>
                                        </div>
                                    </div>
                                    <div class="home-box-overlay">
                                        <p>5</p>
                                    </div>
                                </a>
                           </div>

                           <div class="d-flex mt-5 justify-content-center">
                                <div class="text-center">
                                    <a href="" class="btn search-btn">View</a>
                                </div>
                                <div class="text-center">
                                    <a href="" class="btn search-btn">Edit</a>
                                </div>
                                <div class="text-center">
                                    <a href="" class="btn search-btn">Download</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection

@section('page-js')

    <script>
        $('#home').addClass('active');
    </script>

@endsection
