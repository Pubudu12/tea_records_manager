<div class="mt-5"></div>
@include('_PDF.Components.PageTitleComponent', ['title'=>'Overall Market Details'])

<div>
    <table class="max-w-100 table overallDetailTable pdf-marketdashboard summary-tbl">

        <?php foreach ($overallValues['detailValues']['overallElevationRefs'] as $mainKey => $singleRef) {?>
            <tr>
                <td class="{{$singleRef['class']}} refname pt-3">
                    {{$singleRef['name']}}
                </td>

                <?php if(($singleRef['level'] == 1) | ($singleRef['level'] == 2)){
                    if ($singleRef['columns'] != NULL) {
                        foreach ($singleRef['columns'] as $singleColumn) {?>
                            <td class="text-center clr-grey pt-3 font-grey w-600">{{$singleColumn}}</td>
                        <?php }
                    }
                }else {
                    foreach ($singleRef['columns'] as $singleColumnKey => $singleColumn) {?>
                        <td class="pt-3">
                            <div class="d-flex justify-content-around">
                                <div class="">{{$singleColumn}}</div>
                                <div class="ml-4">
                                    @if ($singleRef['status'][$singleColumnKey] == '1')
                                        <label class="arrow_up ">
                                            <img src="{{ asset('assets/pdf/images/up.svg') }}" style="width: 20%;display:block;" alt="Forbes and warkers">
                                        </label>
                                    @elseif ($singleRef['status'][$singleColumnKey] == '0')
                                        <label class="arrow_down">
                                            <img src="{{ asset('assets/pdf/images/down.svg') }}" style="width: 20%;display:block;" alt="Forbes and warkers">
                                        </label>
                                    @else
                                        <label class="arraw_firm text-center">Firm</label>
                                    @endif            
                                </div>
                            </div>
                        </td>
                    <?php }
                }?>                
            </tr>
        <?php }?>
    </table>
</div>