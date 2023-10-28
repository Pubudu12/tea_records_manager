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
                                <div class="col-md-12">
                                    <button type="button" class="btn sm-add" onclick="addWorldTeaProductRow1()" id="add_link_btn"><i class="fa fa-plus"></i></button>
                                </div>                        
                                <table class="table mt-2" id="link_section">
                                    <tbody id="outer-tbody-1">
                                        <tr>
                                            <td></td>
                                            <td class="text-center table-cell-light-blue" colspan="6">
                                                <div class="col-5 offset-4">
                                                    <small>Select Month</small>
                                                    <select name="" class="form-control" id="">
                                                        <option value="" disabled> Select Month</option>
                                                        @foreach ($months as $month)
                                                            <option value="">{{$month->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>                                                
                                                {{-- <h3 class="h3-custom">{{$txtLastMonth}}</h3> --}}
                                            </td>
                                        </tr>

                                        <tr>                                            
                                            <td class="text-center"></td>
                                            <td class="text-center dark-yellow-cell" colspan="3"></td>
                                            <td class="text-center light-yellow-cell" colspan="3">Difference +/-</td>
                                            <td></td>
                                        </tr>

                                        <tr>
                                            <td class="text-center"></td>
                                            <td class="text-center dark-yellow-cell">2022</td>
                                            <td class="text-center dark-yellow-cell">2021</td>
                                            <td class="text-center dark-yellow-cell">2020</td>
                                            <td class="text-center light-yellow-cell">2020 vs 2021</td>
                                            <td class="text-center light-yellow-cell" colspan="2">2021 vs 2022</td>
                                            <td></td>
                                        </tr>
                                        
                                        <tr id="row-inner-1">
                                            <td>
                                                <div>
                                                    <select name="" class="select2 js-example-basic-single" id="">
                                                        <option value="" disabled> Select Country</option>   
                                                        @foreach ($countries as $country)                                                            
                                                            <option value="">{{$country->name}}</option>                                                         
                                                        @endforeach
                                                    </select>
                                                </div>
                                                {{-- <input type="hidden" name="last_month_country[]" value="{{$data['country_id']}}"> --}}
                                               
                                            </td>
                                            <td class="dark-yellow-cell">
                                                <input type="text" class="form-control" placeholder="Value" value="" name="last_month_current_year_val[]">
                                            </td>

                                            <td class="text-center dark-yellow-cell">
                                                <input type="text" class="form-control" placeholder="Value" tabindex="-1" value="" readonly>
                                            </td>
                                            <td class="text-center dark-yellow-cell">
                                                <input type="text" class="form-control" placeholder="Value" tabindex="-1" value="" readonly>
                                            </td>                                                
                                            <td class="light-yellow-cell">
                                                <input type="text" class="form-control" name="last_month_LP_val[]" value="" placeholder="Value">
                                            </td>
                                            <td class="light-yellow-cell">
                                                <input type="text" class="form-control" name="last_month_CL_val[]" value="" placeholder="Value">
                                            </td>
                                            <td><button type="button" class="btn btn-sm btn-danger" onclick="deleteWorldTeaProdRow1(this)"><i class="fa fa-trash"></i></button></td>
                                        </tr>
                                        {{-- @endforeach --}}
                                    </tbody>
                                </table>

                                
                                <div class="col-md-12 mt-5">
                                    <button type="button" class="btn sm-add" onclick="addWorldTeaProductRow()" id="add_link_btn"><i class="fa fa-plus"></i></button>
                                </div>
                                <table class="table mt-2" id="link_section">
                                    <tbody id="outer-tbody-2">
                                        <tr>
                                            <td></td>
                                            <td class="text-center table-cell-light-blue" colspan="6">
                                                {{-- <h3 class="h3-custom">{{$txtoneToLast_month}}</h3> --}}
                                                <div class="col-5 offset-4">
                                                    <small>Select Month</small>
                                                    <select name="" class="form-control" id="">
                                                        <option value="" disabled> Select Month</option>   
                                                        @foreach ($months as $month)
                                                            <option value="">{{$month->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div> 
                                            </td>
                                        </tr>

                                        <tr>                                            
                                            <td class="text-center"></td>
                                            <td class="text-center dark-yellow-cell" colspan="3"></td>
                                            <td class="text-center light-yellow-cell" colspan="3">Difference +/-</td>
                                            <td></td>
                                        </tr>

                                        <tr>
                                            <td class="text-center"></td>
                                            <td class="text-center dark-yellow-cell">2022</td>
                                            <td class="text-center dark-yellow-cell">2021</td>
                                            <td class="text-center dark-yellow-cell">2020</td>
                                            <td class="text-center light-yellow-cell">2020 vs 2021</td>
                                            <td class="text-center light-yellow-cell" colspan="2">2021 vs 2022</td>
                                            <td></td>
                                        </tr>
                                        
                                        <tr id="row-inner-2">
                                            <td>
                                                <div>
                                                    <select name="" class="select2 js-example-basic-single" id="">
                                                        <option value="" disabled> Select Country</option>   
                                                        @foreach ($countries as $country)                                                            
                                                            <option value="">{{$country->name}}</option>                                                         
                                                        @endforeach
                                                    </select>
                                                </div>
                                                {{-- <input type="hidden" name="last_month_country[]" value="{{$data['country_id']}}"> --}}
                                               
                                            </td>
                                            <td class="dark-yellow-cell">
                                                <input type="text" class="form-control" placeholder="Value" value="" name="last_month_current_year_val[]">
                                            </td>

                                            <td class="text-center dark-yellow-cell">
                                                <input type="text" class="form-control" placeholder="Value" tabindex="-1" value="" readonly>
                                            </td>
                                            <td class="text-center dark-yellow-cell">
                                                <input type="text" class="form-control" placeholder="Value" tabindex="-1" value="" readonly>
                                            </td>                                                
                                            <td class="light-yellow-cell">
                                                <input type="text" class="form-control" name="last_month_LP_val[]" value="" placeholder="Value">
                                            </td>
                                            <td class="light-yellow-cell">
                                                <input type="text" class="form-control" name="last_month_CL_val[]" value="" placeholder="Value">
                                            </td>
                                            <td><button type="button" class="btn btn-sm btn-danger" onclick="deleteWorldTeaProdRow2(this)"><i class="fa fa-trash"></i></button></td>
                                        </tr>
                                        {{-- @endforeach --}}
                                    </tbody>
                                </table>                                


                                <div class="col-md-12 mt-5">
                                    <button type="button" class="btn sm-add" onclick="addWorldTeaProductRow3()" id="add_link_btn"><i class="fa fa-plus"></i></button>
                                </div>

                                <table class="table mt-2" id="link_section">
                                    <tbody id="outer-tbody-3">
                                        <tr>
                                            <td></td>
                                            <td class="text-center table-cell-light-blue" colspan="6">
                                                {{-- <h3 class="h3-custom">{{$txtsecondToLast_month}}</h3> --}}
                                                <div class="col-5 offset-4">
                                                    <small>Select Month</small>
                                                    <select name="" class="form-control" id="">
                                                        <option value="" disabled> Select Month</option>   
                                                        @foreach ($months as $month)
                                                            <option value="">{{$month->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div> 
                                            </td>
                                        </tr>

                                        <tr>                                            
                                            <td class="text-center"></td>
                                            <td class="text-center dark-yellow-cell" colspan="3"></td>
                                            <td class="text-center light-yellow-cell" colspan="3">Difference +/-</td>
                                            <td></td>
                                        </tr>

                                        <tr>
                                            <td class="text-center"></td>
                                            <td class="text-center dark-yellow-cell">2022</td>
                                            <td class="text-center dark-yellow-cell">2021</td>
                                            <td class="text-center dark-yellow-cell">2020</td>
                                            <td class="text-center light-yellow-cell">2020 vs 2021</td>
                                            <td class="text-center light-yellow-cell" colspan="2">2021 vs 2022</td>
                                            <td></td>
                                        </tr>
                                        
                                        <tr id="row-inner-3">
                                            <td>
                                                <div>
                                                    <select name="" class="select2 js-example-basic-single" id="">
                                                        <option value="" disabled> Select Country</option>   
                                                        @foreach ($countries as $country)                                                            
                                                            <option value="">{{$country->name}}</option>                                                         
                                                        @endforeach
                                                    </select>
                                                </div>
                                                {{-- <input type="hidden" name="last_month_country[]" value="{{$data['country_id']}}"> --}}
                                               
                                            </td>
                                            <td class="dark-yellow-cell">
                                                <input type="text" class="form-control" placeholder="Value" value="" name="last_month_current_year_val[]">
                                            </td>

                                            <td class="text-center dark-yellow-cell">
                                                <input type="text" class="form-control" placeholder="Value" tabindex="-1" value="" readonly>
                                            </td>
                                            <td class="text-center dark-yellow-cell">
                                                <input type="text" class="form-control" placeholder="Value" tabindex="-1" value="" readonly>
                                            </td>                                                
                                            <td class="light-yellow-cell">
                                                <input type="text" class="form-control" name="last_month_LP_val[]" value="" placeholder="Value">
                                            </td>
                                            <td class="light-yellow-cell">
                                                <input type="text" class="form-control" name="last_month_CL_val[]" value="" placeholder="Value">
                                            </td>
                                            <td><button type="button" class="btn btn-sm btn-danger" onclick="deleteWorldTeaProdRow3(this)"><i class="fa fa-trash"></i></button></td>
                                        </tr>
                                        {{-- @endforeach --}}
                                    </tbody>
                                </table>

                                <input type="hidden" name="first_current_year" value="{{$currentYear}}">
                                <input type="hidden" name="first_lastYear" value="{{$lastYear}}">
                                <input type="hidden" name="first_prvLastYear" value="{{$prvLastYear}}">
                                <input type="hidden" name="last_month" value="{{$last_month}}">
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
