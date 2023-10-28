<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use App\Http\Traits\DBOperationsTrait;
use App\Http\Traits\MarketDashboardTrait;
use App\Http\Traits\AuctionHighlightsTrait;
use App\Models\sales_list;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\View\View;

class PDFGenerationController extends Controller
{
    use MarketDashboardTrait;
    use DBOperationsTrait;
    use AuctionHighlightsTrait;

    private $session_sale_code;

    public function __construct(){

        $this->middleware(function ($request, $next){

            $this->session_sale_code = session()->get('sale_code');  
            
            return $next($request);
        });
    }

    public function generateTestPDF($type){

        $data = array('name' => "Sajeevan");

        if($type == "html"){
            return View('_PDF.index',['data'=>$data, 'type'=>'html']);
        }else{

            $pdf = PDF::loadView('_PDF.index', ['data'=>$data, 'type'=>'pdf']);

            // Save on disk
            // $pdf->save('assets/invoice.pdf');

            // Download
            return $pdf->stream('download.pdf');
            // return $pdf->download('invoice.pdf');

        }

    }


    public function generateAuctionHighlights($type){

        $pdfButton = 'display-none';
        $marketDashboard = $this->fetchMarketDashboardData($this->session_sale_code);
        $overallValues = $this->fetchOverallValues($this->session_sale_code);
        $auctionDescriptions = $this->fetchAuctionDescriptions($this->session_sale_code);
        $auctionAddNewPageDetails = $this->fetchAddNewPageDetails($this->session_sale_code);
        $catalogueDetails = $this->fetchCataloguesQuantities($this->session_sale_code);
        $reportDetails = $this->fetchDetailsBySalesCode(new sales_list(),'sales_code',$this->session_sale_code);
        $tempSales = array('currentSale'=>$marketDashboard['currentSale'],'lastSale'=>$marketDashboard['lastSale'],'saleBeforelastSale'=>$marketDashboard['saleBeforelastSale']);
        
        if($type == "html"){

            $pdfButton = 'pdfButton';

            return View('_PDF.auction',['dashboardData'=>$marketDashboard['previousData'],'overallValues'=>$overallValues, 'auctionDescriptions'=>$auctionDescriptions,'auctionAddNewPageDetails'=>$auctionAddNewPageDetails,
                                            'catalogueDetails'=>$catalogueDetails,
                                            'currentSaleCode'=>$reportDetails->sales_code,
                                            'yearList'=>$marketDashboard['yearList'],
                                            'salesCodes'=>$tempSales, 
                                            'pdfButton'=>$pdfButton,
                                            'type'=>'pdf']);
        }else{          

            // view()->share('dashboardData',$marketDashboard['previousData']);

            $pdf = PDF::loadView('_PDF.auction', ['dashboardData'=>$marketDashboard['previousData'],
                                                    'overallValues'=>$overallValues, 
                                                    'auctionDescriptions'=>$auctionDescriptions,
                                                    'auctionAddNewPageDetails'=>$auctionAddNewPageDetails,
                                                    'catalogueDetails'=>$catalogueDetails,
                                                    'currentSaleCode'=>$reportDetails->sales_code,
                                                    'yearList'=>$marketDashboard['yearList'],
                                                    'pdfButton'=>$pdfButton,
                                                    'salesCodes'=>$tempSales, 'type'=>'pdf']);

            // Download
            return $pdf->stream('auctionHighlights.pdf');
            // return View('_PDF.auction',['dashboardData'=>$marketDashboard['previousData'], 'salesCodes'=>$marketDashboard['saleCodes'], 'type'=>'pdf']);
            // return $pdf->download('invoice.pdf');
        }
    }

    // public function GoBack(){
    //     pdfGoBack
    // }
}

?>
