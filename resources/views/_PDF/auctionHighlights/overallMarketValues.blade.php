<?php if (count($overallValues['values']) > 0) {?>

    <div class="mt-5"></div>
    @include('_PDF.Components.PageTitleComponent', ['title'=>'Overall Market'])

    <div>
        <table class="table table-responsive pdf-marketdashboard">
            <thead>
                <tr class="pdf-fist-row">
                    <th></th>
                    <th class="width-30">Quantity (M/kg)</th>
                    <th class="width-40">Demand</th>
                </tr>
            </thead>

            <tbody>
                <?php                
                    foreach ($overallValues['values'] as $key => $value) { 
                        if ($value->refID == '10') {?>
                            <tr class="grey-border">
                                <td class="table-bg-dark-green text-white w-600">{{$value->refName}}</td>
                                <td class="width-30 table-bg-dark-green text-center text-white w-600">{{$value->quantity_m_kgs}}</td>
                                <td class="width-40 table-bg-dark-green text-center text-white w-600">{{$value->demand}}</td>
                            </tr>
                        <?php } else {?>
                            <tr class="grey-border">
                                <td class="font-grey text-left text-white">{{$value->refName}}</td>
                                <td class="width-30 table-bg-light-yellow text-center w-500">{{$value->quantity_m_kgs}}</td>
                                <td class="width-40 table-bg-light-blue text-center w-500">{{$value->demand}}</td>
                            </tr>
                        <?php }
                        ?>                    
                    <?php }?>
                
            </tbody>
        </table>
    </div>
<?php }?>


