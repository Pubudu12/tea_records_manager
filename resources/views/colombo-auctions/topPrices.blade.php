<?php
use App\Http\Controllers\General\DefaultFunctions;
?>

@extends('theme.partials.home')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/topPrices.css') }}">
@endsection

@section('content')

    
    <!-- Container-fluid starts-->
    <div class="page-body">

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12 mb-40">
                            <h1 class="header-font1">Top Prices</h1>
                        </div>
                    </div>

                    @foreach ($topPricesSets as $mainKey => $singleSetMarks)

                        {{-- Single Form START --}}
                        <form id="reportForm" data-action-after=2 data-validate=false method="POST" action="/top-prices">
                            @csrf

                            <div class="comment-first-section">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="subtitle text"> {{ $singleSetMarks['name'] }} </h4>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <button type="button" class="btn sm-add" onclick="addTopPriceDataRow('{{$mainKey}}')" id="add_link_btn"><i class="fa fa-plus"></i></button>
                                    </div> --}}

                                    <div class="col-md-12">
                                        <table class="table topPrice-singletable">
                                            <thead>
                                                <tr class="bg-dark">
                                                    <td><h5 class="text-white">Marks</h5></td>
                                                    <td class="text-end"><h5 class="text-white text-end">Grade</h5></td>
                                                    <td class="text-end"><h5 class="text-white text-end">@</h5></td>
                                                    <td class="text-end"><h5 class="text-white text-end">Value</h5></td>
                                                    <td></td>
                                                </tr>
                                            </thead>

                                            <tbody id="link_section_{{$mainKey}}">

                                                @isset($singleSetMarks['marks'])

                                                    @foreach ($singleSetMarks['marks'] as $innerKey => $singleMark)
                                                        <input type="hidden" name="parent_code" value="{{$singleSetMarks['main_code']}}">
                                                        <tr id="add-link_{{$mainKey}}">

                                                            <td class="td-flexselect">
                                                                
                                                                {{-- @if ($singleMark['subRegionSet'] == NULL) --}}
                                                                    {{-- <select name="mark[]" class="mark-combo flexselect">
                                                                        <option value="null" selected disabled>Select the mark</option>
                                                                        @foreach ($singleSetMarks['marks'] as $listOfMarks)
                                                                            <option value="{{ $listOfMarks['code'] }}" {{ DefaultFunctions::comboBoxSelected($listOfMarks['code'], $singleMark['code']) }} > {{ $listOfMarks['name'] }} </option>
                                                                        @endforeach
                                                                    </select> --}}
                                                                    <input type="text" placeholder="Mark Name" name="mark[]" value="{{$singleMark['name']}}" required>                                                                    
                                                                    
                                                                    {{-- <input type="hidden" name="setOfMarks" id="setOfMarks" value="{{$singleSetMarks['marks']}}"> --}}
                                                                {{-- @else --}}
                                                                    {{-- <input type="text" placeholder="Mark Name" name="mark[]"> --}}
                                                                    {{-- <select name="mark[]" class="mark-combo flexselect">
                                                                        <option value="null" selected disabled>Select the mark</option>
                                                                        @foreach ($singleMark['subRegionSet'] as $listOfMarks)
                                                                            <option value="{{ $listOfMarks->code }}"> {{ $listOfMarks->name }} </option>
                                                                        @endforeach
                                                                    </select> --}}
                                                                    <?php //$setOfMarks = $singleMark['subRegionSet'];?>
                                                                    {{-- <input type="hidden" name="setOfMarks" id="setOfMarks" value="{{$singleMark['subRegionSet']}}"> --}}
                                                                {{-- @endif --}}
                                                                
                                                                <select class="js-example-basic-single" name="asterisk[]">
                                                                    <option value="" {{ DefaultFunctions::comboBoxSelected( "", $singleMark['asterisk']) }}></option>
                                                                    <option value="*" {{ DefaultFunctions::comboBoxSelected( "*", $singleMark['asterisk']) }}>*</option>
                                                                    <option value="**" {{ DefaultFunctions::comboBoxSelected( "**", $singleMark['asterisk']) }}>**</option>
                                                                </select>
                                                            </td>

                                                            <td> <input type="text" placeholder="Eg: BOPF, BOP" name="varities[]" value="{{ $singleMark['varities'] }}"> </td>

                                                            <td>
                                                                <label class="toggle-two">
                                                                    <input type="checkbox" name="is_forbes[]" value="{{$singleMark['code']}}_{{$innerKey}}" {{ DefaultFunctions::IsCheckedInput($singleMark['is_forbes']) }} >
                                                                    <span class="toggle-tw-slider round"></span>
                                                                    {{-- @if ($singleMark['is_forbes'] == 0)
                                                                        <input type="checkbox" name="is_forbes[]" value="{{$singleMark['code']}}">
                                                                    @else
                                                                        <input type="checkbox" name="is_forbes[]" value="{{$singleMark['code']}}" checked >
                                                                    @endif
                                                                    <span class="toggle-tw-slider round"></span> --}}
                                                                </label>
                                                            </td>

                                                            <td>
                                                                <input type="number" placeholder="Value" name="value[]"  value="{{ $singleMark['value'] }}">
                                                            </td>

                                                            <td>
                                                                <button tabindex="-1" class="btn btn-sm btn-success remove-btn-custom-top" id="{{$mainKey}}_{{$innerKey}}" type="button" onclick="addNewRow('{{$mainKey}}','{{$innerKey}}','{{$singleSetMarks['main_code']}}')"><i class="fa fa-plus"></i></button>
                                                                <button tabindex="-1" class="btn remove-btn-1 remove-btn-custom-top" type="button" id="removeLink" onclick="deleteTopPriceDetail(this,'{{$mainKey}}')"><i class="fa fa-trash"></i></button>
                                                            </td>

                                                        </tr>

                                                    @endforeach

                                                @endisset

                                            </tbody>
                                        </table>

                                        <input type="hidden" name="refresh" id="refresh" value="/top-prices">
                                        @include('_GeneralComponents.formDefaultSubmitButton',['refresh'=>'/top-prices'])
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="setOfResions" id="setOfResions" value="{{$regionSet}}">
                        </form>
                        {{-- Form END --}}

                    @endforeach

                    @include('_GeneralComponents.formBottomButtons', ['previous'=>'/market-analysis/LOW_GROWN', 'export'=>'/exportTopPrices', 'next'=> '/qualtity-sold'])
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <script>

        function addNewRow(mainKey,innerKey,parentCode) {
            console.log(parentCode)
            // alert(innerKey)
            
            var btn_clicked = document.getElementById(mainKey+'_'+innerKey);
            
            var tr_referred = btn_clicked.parentNode.parentNode;
            v = btn_clicked.parentNode.parentNode.parentNode;
            
            const nextInnerKey = Number(innerKey) + Number(1);

            setOfResions = [];
            setOfResions = $('#setOfResions').val();            
            
            // console.log(setOfResions)
            // options = '<select name="mark[]" class="mark-combo flexselect"><option value="null" selected disabled>Select the mark</option><option value="null" >Harangala</option>';
            // setOfResions.forEach(element => {
            //     options += '<option value="'+element.id+'">"'+element.name+'"</option>';
            // });

            // options += '</select>';
                        
            var tr = document.createElement('tr');
            tr.setAttribute("id","add-link_"+mainKey);
            tr.innerHTML = '<td><input type="text" placeholder="Mark Name" class="mr-2" name="mark[]" required><input type="hidden" name="parent_dode[]" value="'+parentCode+'">'+
                            '<select class="js-example-basic-single ml-2" name="asterisk[]"><option value=""></option><option value="*">*</option><option value="**">**</option></select></td><td><input type="text" placeholder="Eg: BOPF, BOP" name="varities[]"></td>'+
                            '<td><label class="toggle-two"><input type="checkbox" name="is_forbes[]"><span class="toggle-tw-slider round"></span></label></td><td><input type="number" placeholder="Value"  name="value[]"></td>'+
                            '<td><button tabindex="-1" class="btn btn-sm btn-success" id="'+mainKey+'_'+nextInnerKey+'" type="button" onclick="addNewRow('+"'"+mainKey+"'"+','+"'"+nextInnerKey+"'"+')"><i class="fa fa-plus"></i></button><button tabindex="-1" class="btn remove-btn-1 remove-btn-custom-top" type="button" id="removeLink" onclick="deleteTopPriceDetail(this,'+"'"+mainKey+"'"+')"><i class="fa fa-trash"></i></button></td>';
            
            v.appendChild(tr);
            tr_referred.parentNode.insertBefore(tr, tr_referred.nextSibling);
            return tr;
        }
    </script>    

@endsection
