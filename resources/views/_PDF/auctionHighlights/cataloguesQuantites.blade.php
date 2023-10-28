<div class="mt-5"></div>

@if (($catalogueDetails['awaiting1_lots'] != 0) & ($catalogueDetails['awaiting2_lots'] != 0))
@include('_PDF.Components.PageTitleComponent', ['title'=>'Catalogued quantities for the upcoming sales'])

<div class="d-flex justify-content-between">
    <div class="col-md-5 catlog-box-outer" style="display: block">
        <div class="catlog-inner">
            <div><b>{{$catalogueDetails['awaiting_sale_code_1']}}</b></div>
            <div class="date-text">{{$catalogueDetails['awaiting_sale_1_dates']}}</div>

            <div class="d-flex justify-content-between pt-2 pb-2">
                <div class="col-md-6 ctg-name">Lots</div>
                <div class="col-md-6 ctg-value">{{$catalogueDetails['awaiting1_lots']}}</div>
            </div>

            <div class="d-flex justify-content-between pt-2 pb-2">
                <div class="col-md-6 ctg-name">Quantity</div>
                <div class="col-md-6 ctg-value">{{$catalogueDetails['awaiting1_quantity']}}</div>
            </div>
        </div>
    </div>

    {{-- <div class="col-md-1"></div> --}}

    <div class="col-md-5 catlog-box-outer" style="display: block">
        <div class="catlog-inner">
            <div><b>{{$catalogueDetails['awaiting_sale_code_2']}}</b></div>
            <div class="date-text">{{$catalogueDetails['awaiting_sale_1_dates']}}</div>

            <div class="d-flex justify-content-between pt-2 pb-2">
                <div class="col-md-6 ctg-name">Lots</div>
                <div class="col-md-6 ctg-value">{{$catalogueDetails['awaiting2_lots']}}</div>
            </div>

            <div class="d-flex justify-content-between pt-2 pb-2">
                <div class="col-md-6 ctg-name">Quantity</div>
                <div class="col-md-6 ctg-value">{{$catalogueDetails['awaiting2_quantity']}}</div>
            </div>
        </div>
    </div>
</div>
@endif
