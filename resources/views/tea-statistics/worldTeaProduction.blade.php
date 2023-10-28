@extends('theme.partials.home')

@section('content')

    <!-- Container-fluid starts-->
    <div class="page-body">

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="container-fluid">                    
                    <div class="row">
                        <div class="col-md-12 mb-40">
                            <h1 class="header-font1">World Tea Production (M/KGS)</h1>
                        </div>
                    </div>

                    @foreach ($dataArray as $mainKey => $innerData)
                        <form id="reportForm" data-action-after=2 data-validate=true method="POST" action="/manipulateWorldTeaProduction">
                            @csrf
                            <div class="comment-first-section">
                                <div class="row">
                                    
                                    <div class="col-md-12">
                                        <button type="button" class="btn sm-add" onclick="addWorldTeaProductRow{{$mainKey}}()" id="add_link_btn"><i class="fa fa-plus"></i></button>
                                    </div>                        
                                    <table class="table mt-2" id="link_section">
                                        <tbody id="outer-tbody-{{$mainKey}}">
                                            <tr>
                                                <td></td>
                                                <td class="text-center table-cell-light-blue" colspan="9">
                                                    <div class="col-5 offset-4">
                                                        <small>Select Month</small>
                                                        <select name="selected_month" class="form-control" id="">
                                                            <option value="" disabled> Select Month</option>
                                                            @foreach ($months as $month)
                                                                <option value="{{$month->id}}" {{($month->id == $innerData['month']) ? 'selected': ''}} >{{$month->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>                                                
                                                </td>
                                            </tr>

                                            <tr>                                            
                                                <td class="text-center"></td>
                                                <td class="text-center dark-yellow-cell" colspan="3">Month Value</td>
                                                <td class="text-center light-yellow-cell" colspan="3">Todate Value</td>
                                                <td class="text-center dark-yellow-cell" colspan="3">Difference +/-</td>
                                                <td></td>
                                            </tr>

                                            <tr>
                                                <td class="text-center"></td>
                                                <td class="text-center dark-yellow-cell">2022</td>
                                                <td class="text-center dark-yellow-cell">2021</td>
                                                <td class="text-center dark-yellow-cell">2020</td>
                                                <td class="text-center light-yellow-cell">2022</td>
                                                <td class="text-center light-yellow-cell">2021</td>
                                                <td class="text-center light-yellow-cell">2020</td>
                                                <td class="text-center dark-yellow-cell">2020 vs 2021</td>
                                                <td class="text-center dark-yellow-cell" colspan="2">2021 vs 2022</td>
                                                <td></td>
                                            </tr>
                                            
                                            @foreach ($innerData['dataset'] as $innerkey => $values)
                                                <tr id="row-inner-{{$mainKey}}">
                                                    <td>
                                                        <div>
                                                            <select name="country[]" class="select2 js-example-basic-single" id="">
                                                                <option value="" disabled> Select Country</option>   
                                                                @foreach ($countries as $country)                                                            
                                                                    <option value="{{$country->id}}" {{($country->id == $values['country_id']) ? 'selected': ''}}>{{$country->name}}</option>                                                         
                                                                @endforeach
                                                            </select>
                                                        </div>                                                
                                                    </td>
                                                    <td class="dark-yellow-cell">
                                                        <input type="text" class="form-control" placeholder="Value" value="{{$values['current_year_price']}}" name="current_year_value[]">
                                                    </td>
                                                    <td class="text-center dark-yellow-cell">
                                                        <input type="text" class="form-control" placeholder="Value" tabindex="-1" value="{{$values['lastYear_current_price']}}" readonly>
                                                    </td>
                                                    <td class="text-center dark-yellow-cell">
                                                        <input type="text" class="form-control" placeholder="Value" tabindex="-1" value="{{$values['yearBeforelastYear_current_price']}}" readonly>
                                                    </td>
                                                    <td class="light-yellow-cell">
                                                        <input type="text" class="form-control" placeholder="Value" value="{{$values['todate_price']}}" name="todate_value[]">
                                                    </td>
                                                    <td class="text-center light-yellow-cell">
                                                        <input type="text" class="form-control" placeholder="Value" tabindex="-1" value="" readonly>
                                                    </td>
                                                    <td class="text-center light-yellow-cell">
                                                        <input type="text" class="form-control" placeholder="Value" tabindex="-1" value="" readonly>
                                                    </td>                                                
                                                    <td class="dark-yellow-cell">
                                                        <input type="text" class="form-control" name="last_previous_value[]" value="{{$values['last_previous_years_difference']}}" placeholder="Value">
                                                    </td>
                                                    <td class="dark-yellow-cell">
                                                        <input type="text" class="form-control" name="currenct_last_value[]" value="{{$values['current_previous_years_difference']}}" placeholder="Value">
                                                    </td>
                                                    <td><button type="button" class="btn btn-sm btn-danger" onclick="deleteWorldTeaProdRow{{$mainKey}}(this)"><i class="fa fa-trash"></i></button></td>
                                                </tr>
                                            @endforeach                                           
                                        </tbody>
                                    </table>

                                    <input type="hidden" name="first_current_year" value="{{$currentYear}}">
                                    <input type="hidden" name="first_lastYear" value="{{$lastYear}}">
                                    <input type="hidden" name="first_prvLastYear" value="{{$prvLastYear}}">
                                    <input type="hidden" name="last_month" value="{{$innerData['month']}}">
                                    <input type="hidden" name="type" value="{{$innerData['name']}}">
                                    @include('_GeneralComponents.formDefaultSubmitButton')
                                </div>  
                            </div>   
                        </form>   
                    @endforeach   

                    
                    @include('_GeneralComponents.formBottomNextPrevOnly', ['previous'=>'/major-importers', 'next'=> '/awaitingSales1'])
                  
                </div>                
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('page-js')
    <script src="{{ asset('assets/js/form/calculations/worldTeaProduction.js') }}"></script>
@endsection
