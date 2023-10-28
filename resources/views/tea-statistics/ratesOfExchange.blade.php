@extends('theme.partials.home')

@section('content')

    <!-- Container-fluid starts-->
    <div class="page-body">

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="container-fluid">

                    <form id="reportForm" data-action-after=2 data-validate=true method="POST" action="/manipulateRatesExcnge">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-40">
                                <h1 class="header-font1">Rates Of Exchange</h1>
                                <h6>Approx per unit of currency</h6>
                            </div>
                        </div>

                        <div class="comment-first-section">                            
                            <div class="row">
                                <table class="table rateOfExCh_tbl"  id="link_section">
                                    <tr>
                                        <td class="rateOfExCh_one">Year</td>
                                        <td class="rateOfExCh_two text-center">{{$fetchsalesDetails->year}}</td>
                                    </tr>

                                    @if ($ratesExchange == NULL)
                                        <tr>
                                            <td class="rateOfExCh_one">
                                                USD
                                            </td>
                                            <td class="rateOfExCh_two text-center tbl-select-cell-30">
                                                <input type="text" name="usd_price" class="form-control">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                STG-PD
                                            </td>
                                            <td class="text-center tbl-select-cell-30">
                                                <input type="text" name="stg_price" class="form-control">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                EURO
                                            </td>
                                            <td class="text-center tbl-select-cell-30">
                                                <input type="text" name="euro_price" class="form-control">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                YUAN
                                            </td>
                                            <td class="text-center tbl-select-cell-30">
                                                <input type="text" name="yuan_price" class="form-control">
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td>
                                                USD
                                            </td>
                                            <td class="text-center tbl-select-cell-30">
                                                <input type="text" name="usd_price" value="{{($ratesExchange->usd != NULL) ? number_format($ratesExchange->usd,2) : ''}}" class="form-control">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                STG-PD
                                            </td>
                                            <td class="text-center tbl-select-cell-30">
                                                <input type="text" name="stg_price" value="{{($ratesExchange->stg_pd != NULL) ? number_format($ratesExchange->stg_pd,2) : ''}}" class="form-control">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                EURO
                                            </td>
                                            <td class="text-center tbl-select-cell-30">
                                                <input type="text" name="euro_price" value="{{($ratesExchange->euro != NULL) ? number_format($ratesExchange->euro,2) : ''}}" class="form-control">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                YUAN
                                            </td>
                                            <td class="text-center tbl-select-cell-30">
                                                <input type="text" name="yuan_price" value="{{($ratesExchange->yuan != NULL) ? number_format($ratesExchange->yuan,2) : ''}}" class="form-control">
                                            </td>
                                        </tr>
                                    @endif
                                    
                                </table>
                            </div>

                            @if ($ratesExchange != NULL)
                                <div class="row mt-5">
                                    <div class="col-md-7">
                                        <label for="">Source</label>
                                        <input type="text" name="source" value="{{$ratesExchange->source_text}}" class="form-control">
                                    </div>
                                </div>
                            @else
                                <div class="row mt-5">
                                    <div class="col-md-7">
                                        <label for="">Source</label>
                                        <input type="text" name="source" value="" class="form-control">
                                    </div>
                                </div>
                            @endif                            
                        </div>                         

                        {{-- <div>
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="/qualtity-sold" class="previous-btn custom-btn-save">PREVIOUS</a>
                                </div>
                                <div class="col-md-6">
                                    <input type="hidden" name="sale_code" value="">      
                                    <a href="/national-tea-sales-average" class="next-btn float-right custom-btn-save mr-2">NEXT</a>
                                </div>
                            </div>
                        </div>  --}}
                        <input type="hidden" name="year" value="{{$fetchsalesDetails->year}}">
                        @include('_GeneralComponents.formBottomButtons', ['previous'=>'/qualtity-sold', 'next'=> '/national-tea-average'])

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection