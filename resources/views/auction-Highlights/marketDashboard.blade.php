@extends('theme.partials.home')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Container-fluid starts-->
    <div class="page-body">

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="container-fluid">                    
                    <form id="reportForm" data-action-after=2 data-validate=true method="POST" action="/addMarketDashboardDetails">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="header-font1">Market Dashboard</h1>
                                <h5>Details of Quantity Sold</h5>
                                <h6>( Public Auction, Private Sales and forward Contracts )</h6>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-12 crop-we-section">
                                <table class="table order-ofsale-tbl ink_section"  id="link_section">
                                    <tr>
                                        <th></th>
                                        <th colspan="3">Quantity ( M/Kgs )</th>
                                        <th colspan="3">AVG Price ( LKR )</th>
                                        <th colspan="3">AVG Price ( USD )</th>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td class="text-center" style="background: #e9f0e9">
                                            {{$fetchMarketDashboardDetails->year}}
                                        </td>
                                        <td class="text-center light-yellow-cell">
                                            {{$lastYear}}
                                        </td>
                                        <td class="text-center light-yellow-cell">
                                            {{$yearBeforeLastYear}}
                                        </td>
                                        <td class="text-center" style="background: #e9f0e9">
                                            {{$fetchMarketDashboardDetails->year}}
                                        </td>
                                        <td class="text-center light-yellow-cell">
                                            {{$lastYear}}
                                        </td>
                                        <td class="text-center light-yellow-cell">
                                            {{$yearBeforeLastYear}}
                                        </td>
                                        <td class="text-center" style="background: #e9f0e9">
                                            {{$fetchMarketDashboardDetails->year}}
                                        </td>
                                        <td class="text-center light-yellow-cell">
                                            {{$lastYear}}
                                        </td>
                                        <td class="text-center light-yellow-cell">
                                            {{$yearBeforeLastYear}}
                                        </td>
                                    </tr>

                                    
                                    @if ($marketDetails == NULL)
                                        <tr class="add-link" id="add-link">
                                            <td><h6 class="text-center">Sale No {{$fetchMarketDashboardDetails->sales_no}}</h6></td>
                                            <td style="background: #e9f0e9;">
                                                <input class="form-control input-text1" name="qty" placeholder="Quantity">
                                            </td>
                                            <td class="light-yellow-cell">
                                                <input class="form-control input-text1" readonly tabindex="-1" value="{{$previousDataArray['prevYearSaleTotalValues']['quantity_m_kgs']}}" placeholder="Quantity">
                                            </td>
                                            <td class="light-yellow-cell">
                                                <input class="form-control input-text1" readonly tabindex="-1" value="{{$previousDataArray['yearBeforePrevYearTotalValues']['quantity_m_kgs']}}" placeholder="Quantity">
                                            </td>
                                            <td style="background: #e9f0e9;">    
                                                <input class="form-control input-text1" name="avg_lkr" id="avg_lkr" placeholder="AVG LKR">
                                            </td> 
                                            <td class="light-yellow-cell">
                                                <input class="form-control input-text1" readonly tabindex="-1" value="{{$previousDataArray['prevYearSaleTotalValues']['avg_price_lkr']}}" placeholder="AVG LKR">
                                            </td>
                                            <td class="light-yellow-cell">
                                                <input class="form-control input-text1" readonly tabindex="-1" value="{{$previousDataArray['yearBeforePrevYearTotalValues']['avg_price_lkr']}}" placeholder="AVG LKR">
                                            </td>
                                            <td style="background: #e9f0e9 ;">
                                                <input class="form-control input-text1" name="avg_usd" id="avg_usd" placeholder="AVG USD" >
                                            </td>
                                            <td class="light-yellow-cell">    
                                                <input class="form-control input-text1" readonly tabindex="-1" value="{{$previousDataArray['prevYearSaleTotalValues']['avg_price_usd']}}" placeholder="AVG USD">
                                            </td> 
                                            <td class="light-yellow-cell">    
                                                <input class="form-control input-text1" readonly tabindex="-1" value="{{$previousDataArray['yearBeforePrevYearTotalValues']['avg_price_usd']}}" placeholder="AVG USD">
                                            </td> 
                                        </tr> 
                                    @else
                                        <tr class="add-link" id="add-link">
                                            <td><h6 class="text-center">Sale No {{$fetchMarketDashboardDetails->sales_no}}</h6></td>
                                            <td style="background: #e9f0e9;">
                                                <input class="form-control input-text1" name="qty" value="{{number_format($marketDetails->quantity_m_kgs,2)}}" placeholder="Quantity">
                                            </td>
                                            <td class="light-yellow-cell">
                                                <input class="form-control input-text1" readonly tabindex="-1" value="{{$previousDataArray['prevYearSaleTotalValues']['quantity_m_kgs']}}" placeholder="Quantity">
                                            </td>
                                            <td class="light-yellow-cell">
                                                <input class="form-control input-text1" readonly tabindex="-1" value="{{$previousDataArray['yearBeforePrevYearTotalValues']['quantity_m_kgs']}}" placeholder="Quantity">
                                            </td>
                                            <td style="background: #e9f0e9;">    
                                                <input class="form-control input-text1" name="avg_lkr" id="avg_lkr" value="{{number_format($marketDetails->avg_price_lkr,2)}}" placeholder="AVG LKR"> <!--onkeyup="setUSDPrice()"-->
                                            </td> 
                                            <td class="light-yellow-cell">
                                                <input class="form-control input-text1" readonly tabindex="-1" value="{{$previousDataArray['prevYearSaleTotalValues']['avg_price_lkr']}}" placeholder="AVG LKR">
                                            </td>
                                            <td class="light-yellow-cell">
                                                <input class="form-control input-text1" readonly tabindex="-1" value="{{$previousDataArray['yearBeforePrevYearTotalValues']['avg_price_lkr']}}" placeholder="AVG LKR">
                                            </td>
                                            <td style="background: #e9f0e9;">
                                                <input class="form-control input-text1" name="avg_usd" id="avg_usd" value="{{number_format($marketDetails->avg_price_usd,2)}}" placeholder="AVG USD">
                                            </td>
                                            <td class="light-yellow-cell">   
                                                <input class="form-control input-text1" readonly tabindex="-1" value="{{$previousDataArray['prevYearSaleTotalValues']['avg_price_usd']}}" placeholder="AVG USD">
                                            </td> 
                                            <td class="light-yellow-cell">   
                                                <input class="form-control input-text1" readonly tabindex="-1" value="{{$previousDataArray['yearBeforePrevYearTotalValues']['avg_price_usd']}}" placeholder="AVG USD">
                                            </td> 
                                        </tr> 
                                    @endif                                                                           
                                </table>
                            </div>
                        </div>
                        
                        <input type="hidden" name="year" value="{{$fetchMarketDashboardDetails->year}}">
                        <input type="hidden" id="sale_code" value="{{session()->get('SelectedSaleCode')}}">
                        
                        <?php $value = '/report/update/'.session()->get('SelectedSaleCode');?>
                        
                        @include('_GeneralComponents.formBottomButtons', ['previous'=> $value , 'next'=> '/overall-market'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')

{{-- <script src="{{ asset('assets/js/validations/auction-highlights/marketDashboard.js') }}"></script> --}}
<script>
    function setUSDPrice() {        
        avg_lkr = $('#avg_lkr').val();
        console.log(avg_lkr);
        sale_code = $('#sale_code').val();

        $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "/getUSDValue",
                type:'GET',
                data: {
                    'avg_lkr': avg_lkr,
                    'sale_code':sale_code
                    },
                success: function(data) {
                    console.log(data);
                    $('#avg_usd').val(data.priceUSD)
                    // result = data;
                },error: function (err) {
                    console.log('ew');
                    console.log(err)
                }
            });
    }
</script>
<script>
    // $('#marketDashboard').addClass('active');
</script>

@endsection