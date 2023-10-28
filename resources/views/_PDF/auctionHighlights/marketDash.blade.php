@include('_PDF.Components.PageTitleComponent', ['title'=>'Market Dashboard'])

<div>
    {{-- <h6>DETAILS OF QUANTITY SOLD</h6>
    <p>(PUBLIC AUCTION, PRIVATE SALES AND FORWARD CONTRACTS)</p> --}}
</div>

<div>
    <table class="table table-responsive pdf-marketdashboard">
        <thead>
            <tr class="pdf-fist-row">
                <th></th>
                <th colspan="3">Quantity (M/kg)</th>
                <th colspan="3">AVG Price (LKR)</th>
                <th colspan="3">AVG Price (USD)</th>
            </tr>
            <tr class="grey-border">
                <th></th>
                <th class="table-bg-light-green">{{$yearList['currectYear']}}</th>
                <th class="table-bg-light-yellow">{{$yearList['lastYear']}}</th>
                <th class="table-bg-light-orange">{{$yearList['yearBeforeLastYear']}}</th>
                <th class="table-bg-light-green">{{$yearList['currectYear']}}</th>
                <th class="table-bg-light-yellow">{{$yearList['lastYear']}}</th>
                <th class="table-bg-light-orange">{{$yearList['yearBeforeLastYear']}}</th>
                <th class="table-bg-light-green">{{$yearList['currectYear']}}</th>
                <th class="table-bg-light-yellow">{{$yearList['lastYear']}}</th>
                <th class="table-bg-light-orange">{{$yearList['yearBeforeLastYear']}}</th>
            </tr>
        </thead>

        <tbody>
            <?php 
                // foreach ($dashboardData as $key => $singleData) { ?>

                    <tr class="grey-border">
                        <td class="font-grey">Sale Num {{$salesCodes['saleBeforelastSale']}} </td>
                        <td class="table-bg-light-green">{{$dashboardData['prevLastSaleCurrntdata']['quantity_m_kgs']}}</td>
                        <td class="table-bg-light-yellow">{{$dashboardData['prevLastSaleprevYdata']['quantity_m_kgs']}}</td>
                        <td class="table-bg-light-orange">{{$dashboardData['prevLastSaleYBPYdata']['quantity_m_kgs']}}</td>
                        <td class="table-bg-light-green">{{$dashboardData['prevLastSaleCurrntdata']['avg_price_lkr']}}</td>
                        <td class="table-bg-light-yellow">{{$dashboardData['prevLastSaleprevYdata']['avg_price_lkr']}}</td>
                        <td class="table-bg-light-orange">{{$dashboardData['prevLastSaleYBPYdata']['avg_price_lkr']}}</td>
                        <td class="table-bg-light-green">{{$dashboardData['prevLastSaleCurrntdata']['avg_price_usd']}}</td>
                        <td class="table-bg-light-yellow">{{$dashboardData['prevLastSaleprevYdata']['avg_price_usd']}}</td>
                        <td class="table-bg-light-orange">{{$dashboardData['prevLastSaleYBPYdata']['avg_price_usd']}}</td>
                    </tr>

                    
                    <tr class="grey-border">
                        <td class="font-grey">Sale Num {{$salesCodes['lastSale']}} </td>
                        <td class="table-bg-light-green">{{$dashboardData['lastSaleCurrntdata']['quantity_m_kgs']}}</td>
                        <td class="table-bg-light-yellow">{{$dashboardData['lastSaleprevYdata']['quantity_m_kgs']}}</td>
                        <td class="table-bg-light-orange">{{$dashboardData['lastSaleYBPYdata']['quantity_m_kgs']}}</td>
                        <td class="table-bg-light-green">{{$dashboardData['lastSaleCurrntdata']['avg_price_lkr']}}</td>
                        <td class="table-bg-light-yellow">{{$dashboardData['lastSaleprevYdata']['avg_price_lkr']}}</td>
                        <td class="table-bg-light-orange">{{$dashboardData['lastSaleYBPYdata']['avg_price_lkr']}}</td>
                        <td class="table-bg-light-green">{{$dashboardData['lastSaleCurrntdata']['avg_price_usd']}}</td>
                        <td class="table-bg-light-yellow">{{$dashboardData['lastSaleprevYdata']['avg_price_usd']}}</td>
                        <td class="table-bg-light-orange">{{$dashboardData['lastSaleYBPYdata']['avg_price_usd']}}</td>
                    </tr>

                    <tr class="grey-border">
                        <td class="font-grey">Sale Num {{$salesCodes['currentSale']}} </td>
                        <td class="table-bg-light-green">{{$dashboardData['currentTotalValues']['quantity_m_kgs']}}</td>
                        <td class="table-bg-light-yellow">{{$dashboardData['prevYearSaleTotalValues']['quantity_m_kgs']}}</td>
                        <td class="table-bg-light-orange">{{$dashboardData['yearBeforePrevYearTotalValues']['quantity_m_kgs']}}</td>
                        <td class="table-bg-light-green">{{$dashboardData['currentTotalValues']['avg_price_lkr']}}</td>
                        <td class="table-bg-light-yellow">{{$dashboardData['prevYearSaleTotalValues']['avg_price_lkr']}}</td>
                        <td class="table-bg-light-orange">{{$dashboardData['yearBeforePrevYearTotalValues']['avg_price_lkr']}}</td>
                        <td class="table-bg-light-green">{{$dashboardData['currentTotalValues']['avg_price_usd']}}</td>
                        <td class="table-bg-light-yellow">{{$dashboardData['prevYearSaleTotalValues']['avg_price_usd']}}</td>
                        <td class="table-bg-light-orange">{{$dashboardData['yearBeforePrevYearTotalValues']['avg_price_usd']}}</td>
                    </tr> 
            <?php //} ?>
        </tbody>
    </table>
</div>
