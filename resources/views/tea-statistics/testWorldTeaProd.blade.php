@extends('theme.partials.home')

@section('content')

    <!-- Container-fluid starts-->
    <div class="page-body">

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="container-fluid">
                    <form id="reportForm" data-action-after=2 data-validate=true method="POST" action="/manipulateWorldTeaProduction">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-40">
                                <h1 class="header-font1">World Tea Production (M/KGS)</h1>
                            </div>
                        </div>
                        
                        <div class="comment-first-section">    
                            
                            <div class="row">                                
                                <table class="table" id="link_section">
                                    <tbody id="outer-tbody-1">
                                        {{-- @foreach ($dataArray as $data)
                                                                                    
                                        <tr>
                                            <td></td>
                                            <td class="text-center table-cell-light-blue" colspan="6"><h3 class="h3-custom">{{$txtLastMonth}}</h3></td>
                                        </tr>

                                        <tr>                                            
                                            <td class="text-center"></td>
                                            <td class="text-center dark-yellow-cell" colspan="3"></td>
                                            <td class="text-center light-yellow-cell" colspan="3">Difference +/-</td>
                                            <td></td>
                                        </tr>

                                        <tr>
                                            <td class="text-center"></td>
                                            <td class="text-center dark-yellow-cell">{{$currentYear}}</td>
                                            <td class="text-center dark-yellow-cell">{{$lastYear}}</td>
                                            <td class="text-center dark-yellow-cell">{{$prvLastYear}}</td>
                                            <td class="text-center light-yellow-cell">{{$prvLastYear}} vs {{$lastYear}}</td>
                                            <td class="text-center light-yellow-cell" colspan="2">{{$lastYear}} vs {{$currentYear}}</td>
                                            <td></td>
                                        </tr>
                                        
                                        <tr id="row-inner-1">
                                            <td>
                                                <div>{{$data['country']}}</div>
                                                <input type="hidden" name="last_month_country[]" value="{{$data['country_id']}}">
                                               
                                            </td>
                                            <td class="dark-yellow-cell">
                                                <input type="text" class="form-control" placeholder="Value" value="{{$data['current_year_price']}}" name="last_month_current_year_val[]">
                                            </td>

                                            <td class="text-center dark-yellow-cell">
                                                <input type="text" class="form-control" placeholder="Value" tabindex="-1" value="{{$data['lastYear_current_price']}}" readonly>
                                            </td>
                                            <td class="text-center dark-yellow-cell">
                                                <input type="text" class="form-control" placeholder="Value" tabindex="-1" value="{{$data['yearBeforelastYear_current_price']}}" readonly>
                                            </td>                                                
                                            <td class="light-yellow-cell">
                                                <input type="text" class="form-control" name="last_month_LP_val[]" value="{{$data['last_previous_years_difference']}}" placeholder="Value">
                                            </td>
                                            <td class="light-yellow-cell">
                                                <input type="text" class="form-control" name="last_month_CL_val[]" value="{{$data['current_previous_years_difference']}}" placeholder="Value">
                                            </td>
                                        </tr>
                                        
                                        @endforeach --}}
                                        @foreach ($dataArray as $data)
                                        <tr>
                                            <td></td>
                                            <td class="text-center table-cell-light-blue" colspan="6"><h3 class="h3-custom">{{$txtLastMonth}}</h3></td>
                                        </tr>

                                        <tr>                                            
                                            <td class="text-center"></td>
                                            <td class="text-center dark-yellow-cell" colspan="3"></td>
                                            <td class="text-center light-yellow-cell" colspan="3">Difference +/-</td>
                                            <td></td>
                                        </tr>

                                        <tr>
                                            <td class="text-center"></td>
                                            <td class="text-center dark-yellow-cell">{{$currentYear}}</td>
                                            <td class="text-center dark-yellow-cell">{{$lastYear}}</td>
                                            <td class="text-center dark-yellow-cell">{{$prvLastYear}}</td>
                                            <td class="text-center light-yellow-cell">{{$prvLastYear}} vs {{$lastYear}}</td>
                                            <td class="text-center light-yellow-cell" colspan="2">{{$lastYear}} vs {{$currentYear}}</td>
                                            <td></td>
                                        </tr>
                                        
                                        <tr id="row-inner-1">
                                            <td>
                                                <div>{{$data['country']}}</div>
                                                <input type="hidden" name="last_month_country[]" value="{{$data['country_id']}}">
                                               
                                            </td>
                                            <td class="dark-yellow-cell">
                                                <input type="text" class="form-control" placeholder="Value" value="{{$data['current_year_price']}}" name="last_month_current_year_val[]">
                                            </td>

                                            <td class="text-center dark-yellow-cell">
                                                <input type="text" class="form-control" placeholder="Value" tabindex="-1" value="{{$data['lastYear_current_price']}}" readonly>
                                            </td>
                                            <td class="text-center dark-yellow-cell">
                                                <input type="text" class="form-control" placeholder="Value" tabindex="-1" value="{{$data['yearBeforelastYear_current_price']}}" readonly>
                                            </td>                                                
                                            <td class="light-yellow-cell">
                                                <input type="text" class="form-control" name="last_month_LP_val[]" value="{{$data['last_previous_years_difference']}}" placeholder="Value">
                                            </td>
                                            <td class="light-yellow-cell">
                                                <input type="text" class="form-control" name="last_month_CL_val[]" value="{{$data['current_previous_years_difference']}}" placeholder="Value">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                
                                <input type="hidden" name="first_current_year" value="{{$currentYear}}">
                                <input type="hidden" name="first_lastYear" value="{{$lastYear}}">
                                <input type="hidden" name="first_prvLastYear" value="{{$prvLastYear}}">
                                <input type="hidden" name="last_month" value="{{$last_month}}">

                                {{-- <div class="col-md-12">
                                    <button type="button" class="btn sm-add" onclick="addWorldTeaProductRow1()" id="add_link_btn"><i class="fa fa-plus"></i></button>
                                </div> --}}

                                {{-- <table class="table mt-5" id="link_section">
                                    <tbody id="outer-tbody-2">
                                        <tr>
                                            <td></td>
                                            <td class="text-center table-cell-light-blue" colspan="6"><h3 class="h3-custom">{{$txtoneToLast_month}}</h3></td>
                                        </tr>

                                        <tr>                                            
                                            <td class="text-center"></td>
                                            <td class="text-center dark-yellow-cell" colspan="3"></td>
                                            <td class="text-center light-yellow-cell" colspan="3">Difference +/-</td>
                                            <td></td>
                                        </tr>

                                        <tr>
                                            <td class="text-center"></td>
                                            <td class="text-center dark-yellow-cell">{{$currentYear}}</td>
                                            <td class="text-center dark-yellow-cell">{{$lastYear}}</td>
                                            <td class="text-center dark-yellow-cell">{{$prvLastYear}}</td>
                                            <td class="text-center light-yellow-cell">{{$prvLastYear}} vs {{$lastYear}}</td>
                                            <td class="text-center light-yellow-cell" colspan="2">{{$lastYear}} vs {{$currentYear}}</td>
                                            <td></td>
                                        </tr>

                                        @foreach ($dataArray['onetolastMonthData'] as $data)
                                            <tr id="row-inner-2">
                                                <td>
                                                    <div>{{$data['country']}}</div>
                                                    
                                                    <input type="hidden" name="onetoLast_country_name[]" value="{{$data['country_id']}}">
                                                </td>
                                                <td class="dark-yellow-cell">
                                                    <input type="text" class="form-control" name="onetoLast_C_val[]" value="{{$data['current_year_price']}}" placeholder="Value">
                                                </td>
                                                <td class="text-center dark-yellow-cell">
                                                    <input type="text" class="form-control" placeholder="Value" tabindex="-1" value="{{$data['lastYear_current_price']}}" readonly>
                                                </td>
                                                <td class="text-center dark-yellow-cell">
                                                    <input type="text" class="form-control" placeholder="Value" tabindex="-1" value="{{$data['yearBeforelastYear_current_price']}}" readonly>
                                                </td>                                                 
                                                <td class="light-yellow-cell">
                                                    <input type="text" class="form-control" name="onetoLast_LP_val[]" value="{{$data['last_previous_years_difference']}}" placeholder="Value">
                                                </td>
                                                <td class="light-yellow-cell">
                                                    <input type="text" class="form-control" name="onetoLast_CL_val[]" value="{{$data['current_previous_years_difference']}}" placeholder="Value">
                                                </td>
                                            </tr>
                                        @endforeach                                        
                                    </tbody>
                                </table> --}}
                                {{-- <input type="hidden" name="second_current_year" value="{{$currentYear}}">
                                <input type="hidden" name="second_lastYear" value="{{$lastYear}}">
                                <input type="hidden" name="second_prvLastYear" value="{{$prvLastYear}}">
                                <input type="hidden" name="oneToLast_month" value="{{$oneToLast_month}}"> --}}

                                {{-- <div class="col-md-12">
                                    <button type="button" class="btn sm-add" onclick="addWorldTeaProductRow2()" id="add_link_btn"><i class="fa fa-plus"></i></button>
                                </div> --}}

                                {{-- <table class="table mt-5" id="link_section">
                                    <tbody id="outer-tbody-3">
                                        <tr>
                                            <td></td>
                                            <td class="text-center table-cell-light-blue" colspan="6"><h3 class="h3-custom">{{$txtsecondToLast_month}}</h3></td>
                                        </tr>

                                        <tr>                                            
                                            <td class="text-center"></td>
                                            <td class="text-center dark-yellow-cell" colspan="3"></td>
                                            <td class="text-center light-yellow-cell" colspan="3">Difference +/-</td>
                                            <td></td>
                                        </tr>

                                        <tr>
                                            <td class="text-center"></td>
                                            <td class="text-center dark-yellow-cell">{{$currentYear}}</td>
                                            <td class="text-center dark-yellow-cell">{{$lastYear}}</td>
                                            <td class="text-center dark-yellow-cell">{{$prvLastYear}}</td>
                                            <td class="text-center light-yellow-cell">{{$prvLastYear}} vs {{$lastYear}}</td>
                                            <td class="text-center light-yellow-cell" colspan="2">{{$lastYear}} vs {{$currentYear}}</td>
                                            <td></td>
                                        </tr>

                                        @foreach ($dataArray['secondtolastMonthData'] as $data)
                                            <tr id="row-inner-3">
                                                <td>
                                                    <div>{{$data['country']}}</div>
                                                    
                                                    <input type="hidden" name="secondtoLast_country_name[]"  value="{{$data['country_id']}}">
                                                </td>
                                                <td class="dark-yellow-cell">
                                                    <input type="text" class="form-control" name="secondtoLast_C_val[]" value="{{$data['current_year_price']}}" placeholder="Value" >
                                                </td>
                                                <td class="text-center dark-yellow-cell">
                                                    <input type="text" class="form-control" placeholder="Value" tabindex="-1" value="{{$data['lastYear_current_price']}}" readonly>
                                                </td>
                                                <td class="text-center dark-yellow-cell">
                                                    <input type="text" class="form-control" placeholder="Value" tabindex="-1" value="{{$data['yearBeforelastYear_current_price']}}" readonly>
                                                </td>                                                 
                                                <td class="light-yellow-cell">
                                                    <input type="text" class="form-control" name="secondtoLast_LP_val[]" value="{{$data['last_previous_years_difference']}}" placeholder="Value" >
                                                </td>
                                                <td class="light-yellow-cell">
                                                    <input type="text" class="form-control" name="secondtoLast_CL_val[]" value="{{$data['current_previous_years_difference']}}" placeholder="Value" >
                                                </td>
                                                
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table> --}}
                                {{-- <input type="hidden" name="third_current_year" value="{{$currentYear}}">
                                <input type="hidden" name="third_lastYear" value="{{$lastYear}}">
                                <input type="hidden" name="third_prvLastYear" value="{{$prvLastYear}}">
                                <input type="hidden" name="secondToLast_month" value="{{$secondToLast_month}}"> --}}

                                {{-- <div class="col-md-12">
                                    <button type="button" class="btn sm-add" onclick="addWorldTeaProductRow3()" id="add_link_btn"><i class="fa fa-plus"></i></button>
                                </div> --}}
                            </div>  
                        </div>          
                        
                        @include('_GeneralComponents.formBottomButtons', ['previous'=>'/major-importers', 'next'=> '/awaitingSales1'])
                        
                    </form>
                </div>                
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('page-js')
    <script src="{{ asset('assets/js/form/calculations/worldTeaProduction.js') }}"></script>
@endsection
