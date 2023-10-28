@extends('theme.partials.home')

@section('content')

    <!-- Container-fluid starts-->
    <div class="page-body">

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <form id="reportForm" data-action-after=2 data-validate=true method="POST" action="/manipulateImporters">
                    @csrf
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="header-font1">Major Importers of Sri Lanka</h1>
                            </div>
                        </div>                  

                        <div>
                            <div class="row">
                                <div class="col-md-12 crop-we-section">

                                    <div class="col-md-12">
                                        <button type="button" class="btn sm-add" onclick="addMajorImportRow()" id="add_link_btn"><i class="fa fa-plus"></i></button>
                                    </div>
                                    <table class="table other-tbl link_section" id="outer-table">
                                        <tr>
                                            <th>Country</th>
                                            <th>Bulk Tea</th>
                                            <th>Packet Tea</th>
                                            <th>Tea Bags</th>
                                            <th>Instant Tea</th>
                                            <th>Green Tea</th>
                                            <th></th>
                                        </tr>

                                        @if ($main != NULL)
                                            @foreach ($updatedDetails as $singleDetail)
                                                <tr class="add-link" id="row-inner">
                                                    <td>
                                                        {{-- {{$singleDetail->country}} --}}
                                                        <select name="ref_id[]" class="form-control select2 js-example-basic-single" id="">
                                                            @foreach ($countries as $country)
                                                                <option value="{{$country->id}}" {{($country->id == $singleDetail->country_id) ? 'selected': ''}}>{{$country->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    
                                                    <td>
                                                        <input class="form-control input-text1" id="inputAddress" placeholder="Bulk Value" value="{{($singleDetail->bulk_tea != NULL) ? number_format($singleDetail->bulk_tea,2): ''}}" name="bulk[]">
                                                    </td>
                                                    <td>
                                                        <input class="form-control input-text1" id="inputAddress" placeholder="Packet Value" value="{{($singleDetail->packeted_tea != NULL) ? number_format($singleDetail->packeted_tea,2): ''}}" name="packet[]">
                                                    </td>
                                                    <td>
                                                        <input class="form-control input-text1" id="inputAddress" placeholder="Tea Bags Value" value="{{($singleDetail->tea_bags != NULL) ? number_format($singleDetail->tea_bags,2): ''}}" name="teabags[]">
                                                    </td>
                                                    <td>
                                                        <input class="form-control input-text1" id="inputAddress" placeholder="Instant Value" value="{{($singleDetail->instant_tea != NULL) ? number_format($singleDetail->instant_tea,2): ''}}" name="instant[]">
                                                    </td>
                                                    <td>
                                                        <input class="form-control input-text1" id="inputAddress" placeholder="Green" value="{{($singleDetail->green_tea != NULL) ? number_format($singleDetail->green_tea,2): ''}}" name="green[]">
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-sm btn-danger" onclick="deleteMajorImportRow(this)" data-sale_code="" id="report_sales_code"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                    {{-- <input type="hidden" name="ref_id[]" value="{{$singleDetail->country_id}}"> --}}
                                                    
                                                </tr>
                                            @endforeach  
                                        @else
                                            {{-- @foreach ($countries as $country) --}}
                                                <tr class="add-link" id="row-inner">
                                                    <td>
                                                        <select name="ref_id[]" class="form-control select2 js-example-basic-single" id="">
                                                            @foreach ($countries as $country)
                                                                <option value="{{$country->id}}">{{$country->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control input-text1" id="inputAddress" placeholder="Bulk Value" name="bulk[]">
                                                    </td>
                                                    <td>
                                                        <input class="form-control input-text1" id="inputAddress" placeholder="Packet Value" name="packet[]">
                                                    </td>
                                                    <td>
                                                        <input class="form-control input-text1" id="inputAddress" placeholder="Tea Bags Value" name="teabags[]">
                                                    </td>
                                                    <td>
                                                        <input class="form-control input-text1" id="inputAddress" placeholder="Instant Value" name="instant[]">
                                                    </td>
                                                    <td>
                                                        <input class="form-control input-text1" id="inputAddress" placeholder="Green" name="green[]">
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-sm btn-danger" onclick="deleteMajorImportRow(this)" data-sale_code="" id="report_sales_code"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                    {{-- <input type="hidden" name="ref_id[]" value="{{$country->id}}"> --}}
                                                    
                                                </tr>
                                            {{-- @endforeach   --}}
                                        @endif                                    
                                          
                                    </table>

                                    <div class="row mt-5">
                                        <div class="col-md-7">                                            
                                            <label for="">Source</label>
                                            @if ($main == NULL)
                                                <input type="text" class="form-control" name="source">
                                                <input type="hidden" name="main_id" value="0">
                                            @else
                                                <input type="text" class="form-control" value="{{$main->source}}" name="source">
                                                <input type="hidden" name="main_id" value="{{$main->id}}">
                                            @endif
                                        </div>
                                    </div>
                                </div>                            
                            </div>                            
                        </div>
                        {{-- world-tea-production --}}
                        @include('_GeneralComponents.formBottomButtons', ['previous'=>'/sri-lanka-tea-exporters', 'next'=> '/world-tea-production'])

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection