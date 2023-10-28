<?php

use App\Http\Controllers\AddNewPageController;
use App\Http\Controllers\auctionHighlights\AuctionHighlightsController;
use App\Http\Controllers\auditTrails\AuditTrailsController;
use App\Http\Controllers\colomboAuctions\CropWeatherController;
use App\Http\Controllers\colomboAuctions\MarketAnalysisController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AwaitingSalesController;
use App\Http\Controllers\DeleteMarketReportController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\GradesController;
use App\Http\Controllers\HighlightsDescriptionController;
use App\Http\Controllers\ImportCountriesController;
use App\Http\Controllers\MajorImportersController;
use App\Http\Controllers\NationalTeaDescriptionController;
use App\Http\Controllers\OrderOfSaleController;
use App\Http\Controllers\OverallMarketController;
use App\Http\Controllers\QuantitySoldController;
use App\Http\Controllers\RatesOfExchangeController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\SalesListController;
use App\Http\Controllers\SriLankanTeaExportController;
use App\Http\Controllers\SriLankanTeaProductionController;
use App\Http\Controllers\suppliments\HolidayNoticeController;
use App\Http\Controllers\teaStatistics\PublicAuctionSalesController;
use App\Http\Controllers\teaStatistics\WorldTeaProductionController;
use App\Http\Controllers\TopPriceController;
use App\Http\Controllers\VendorsController;
use App\Http\Controllers\WorldTeaDescriptionController;
use App\Http\Middleware\AdminMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// PDF Related Routes
include_once 'subRoutes/pdf.php';
include_once 'subRoutes/pdfData.php';

// Login 
Route::get('/',[UserController::class,'showLogin']);
Route::post('/login',[UserController::class,'doLogin']);

// Route::get('/',function(){
//     if (auth()->user()) {
//         auth()->user()->assignRole('editor');
//     }
//     return view('welcome');
// });

// Check if an admin user
Route::middleware([AdminMiddleware::class])->group(function(){
    Route::get('/test', [NationalTeaDescriptionController::class, 'getTest']);
    Route::post('/testtiny',[NationalTeaDescriptionController::class,'testtiny']);
    // logout
    Route::get('/logout', [UserController::class, 'doLogout']);

    // users CRUD
    Route::get('/users', [UserController::class, 'showUserList']);

    Route::get('/user/create', function () {
        return view('users.createUsers');
    });
    Route::post('/user/create',[UserController::class,'register']);

    Route::get('/user/update/{userid}', [UserController::class,'showUpdateUser']);
    Route::post('/user/update', [UserController::class,'updateUser']);

    Route::post('user/delete/{id}',[UserController::class,'deleteUser']);


    // Auit trails
    Route::get('/userActions', [AuditTrailsController::class, 'showUserAuditTrails']);

    
    // country CRUD
    Route::get('/country/create', function () {
        return view('countries/create');
    });
    Route::get('countries',[ImportCountriesController::class,'getCountries']);
    Route::post('/create_country',[ImportCountriesController::class,'createCountry']);

    Route::get('country/update/{id}',[ImportCountriesController::class,'fetchCountriesById']);
    Route::post('update_country',[ImportCountriesController::class,'updateCountry']);

    Route::post('delete_country/{id}',[ImportCountriesController::class,'deleteCountry']);


    // CRUD for Tea Grades
    Route::get('/tea-grades/create', function () {
        return view('tea-grades/create');
    });

    Route::get('/tea-grades',[GradesController::class,'fetchTeaGrades']);
    Route::post('/create-tea-grade',[GradesController::class,'createTeaGrade']);

    Route::get('tea-grades/update/{id}',[GradesController::class,'fetchTeaGradesById']);
    Route::post('update_tea-grade',[GradesController::class,'updateTeaGrade']);

    Route::get('delete_tea-grade/{id}',[GradesController::class,'deleteTeaGrade']);


    // CRUD for Vendors
    Route::get('/vendors/create', function () {
        return view('vendors/create');
    });

    Route::get('reportDashboard',function (){
        return view('report-Dashboard/reportDashboard');
    });

    Route::get('/vendors',[VendorsController::class,'getVendors']);
    Route::post('/createVendor',[VendorsController::class,'createVendor']);

    Route::get('vendors/update/{id}',[VendorsController::class,'fetchVendorById']);
    Route::post('update_vendor',[VendorsController::class,'updateVendor']);

    Route::get('delete_vendor',[VendorsController::class,'deleteVendor']);


    // CRUD for Top Price Regions
    Route::get('/topPriceRegions/create',[RegionController::class,'getRegionForm']);

    Route::get('/regions',[RegionController::class,'getRegions']);
    Route::post('/createTopPriceRegion',[RegionController::class,'createRegion']);
    Route::post('/addTopPriceMarks',[RegionController::class,'addTopPriceMarks']);


    Route::get('topPriceRegions/update/{id}',[RegionController::class,'fetchRegionsById']);
    Route::post('update_top_region',[RegionController::class,'updateRegion']);

    Route::delete('delete_ref_top_price/{id}',[RegionController::class,'deleteRefTopPrice']);


    // CRUD for Sales List
    Route::get('/report/create',[SalesListController::class,'fetchCreateReportForm']);
    Route::get('/searchReport',[SalesListController::class,'searchForReport']);

    // Route::get('/',[SalesListController::class,'getSalesList']);
    Route::get('/dashboard',[SalesListController::class,'getSalesList']);
    Route::post('/createSaleReport',[SalesListController::class,'createReport']);
    Route::get('/report/update/{salecode}',[SalesListController::class,'getUpdatPageDetails']);
    Route::post('/updateSaleReport',[SalesListController::class,'updateReport']);


    // CRUD for market dashboard
    Route::get('/market-dashboard',[AuctionHighlightsController::class,'fetchMarketDashboard']);
    Route::get('/getUSDValue',[AuctionHighlightsController::class,'convertIntoUSD']);
    Route::post('/addMarketDashboardDetails',[AuctionHighlightsController::class,'manipulateMarketDashboardDetails']);

    // CRUD for Overall market
    Route::get('/overall-market',[OverallMarketController::class,'fetchOverallMarket']);
    Route::post('/manipulateOverallMarket',[OverallMarketController::class,'manipulateOverall']);
    Route::post('/manipulateOverallDetails',[OverallMarketController::class,'manipulateOverallDetail']);

    // CRUD for overall highlights
    Route::get('/auction-descriptions',[AuctionHighlightsController::class,'fetchAuctionDescriptions']);
    Route::post('/manipulateAucSmallDescription',[AuctionHighlightsController::class,'manipulateAuctionSmallDesc']);
    Route::post('/manipulateAucLongDescriptions',[AuctionHighlightsController::class,'manipulateAucLongDescriptions']);
    

    // CRUD for overall highlights
    Route::get('/order-of-sales',[OrderOfSaleController::class,'getOrderOfSaleDetails']);
    Route::post('/manipulateOrderOfSale',[OrderOfSaleController::class,'manipulateOrderOfSales']);
    Route::post('/manipilateSettlemetDates',[OrderOfSaleController::class,'manipilateDateSettlemets']);

    // CRUD for Crop & Weather
    Route::get('/crop-and-weather',[CropWeatherController::class,'getCropDetails']);
    Route::post('/manipulateCrops',[CropWeatherController::class,'manipulateCropDetails']);

    Route::get('/market-analysis/{code?}',[MarketAnalysisController::class,'fetchMarketAnalysis']);
    Route::post('/manipulateMarketAnalysis',[MarketAnalysisController::class,'manipulateMarket']);
    Route::post('/manipulateMarketAnalysisDescritions',[MarketAnalysisController::class,'manipulateMarketDescriptions']);

    Route::get('/top-prices',[TopPriceController::class,'getTopPrices']);
    Route::post('/top-prices',[TopPriceController::class,'postTopPrices']);

    Route::get('exportTopPrices',[TopPriceController::class,'exportTopPrices']);

    // Tea statistics
    Route::get('/qualtity-sold',[QuantitySoldController::class,'getQuantitySoldDetails']);
    Route::post('/manipulateQuantitySold',[QuantitySoldController::class,'manipulateQuantitySoldDetails']);

    Route::get('/rates-of-exchange',[RatesOfExchangeController::class,'getQuantitySoldDetails']);
    Route::post('/manipulateRatesExcnge',[RatesOfExchangeController::class,'manipulateRatesExchange']);

    Route::get('/national-tea-average', [NationalTeaDescriptionController::class,'getTeaAverage']);
    Route::get('/national-tea-production', [NationalTeaDescriptionController::class,'getTeaproduction']);
    Route::get('/national-tea-exports', [NationalTeaDescriptionController::class,'getTeaExports']);
    Route::post('/manipulateNationTeaDescriptions',[NationalTeaDescriptionController::class,'manipulateNationalTeaDesc']);

    Route::get('/weekly-tea-sales-average',[PublicAuctionSalesController::class,'getWeeklyPublicAuctionSales']);
    Route::post('/manipulatePublicSale',[PublicAuctionSalesController::class,'manipulatePublicSales']);

    Route::get('/monthly-tea-sales-average',[PublicAuctionSalesController::class,'getMonthlyPublicAuctionSales']);
    Route::post('/manipulateMonthlyPublicSalesAverage',[PublicAuctionSalesController::class,'manipulateMonthlyPublicSales']);

    Route::get('/sri-lanka-tea-exporters',[SriLankanTeaExportController::class,'getSriLankaTeaExports']);
    Route::post('/manipulateTeaExports',[SriLankanTeaExportController::class,'manipulateSriLankaTeaExports']);

    Route::get('/sri-lanka-tea-production',[SriLankanTeaProductionController::class,'getSriLankanTeaProductionDetails']);
    Route::post('/manipulateSriLankanTeaProduction',[SriLankanTeaProductionController::class,'manipulateSriLankanTeaProductionData']);

    Route::get('/world-tea-descriptions',[WorldTeaDescriptionController::class,'getTeaMarketDescriptions']);
    Route::post('/manipulateTeaMarketDesc',[WorldTeaDescriptionController::class,'manipulateTeaMarketDescriptions']);

    Route::get('/major-importers',[MajorImportersController::class,'getImporters']);
    Route::post('/manipulateImporters',[MajorImportersController::class,'manipulateMajorImporters']);

    Route::post('/manipulateAwaitingSales',[AwaitingSalesController::class,'manipulateAwaiting']);
    Route::post('/manipulateAwaitingcatelogues',[AwaitingSalesController::class,'manipulateAwaitingCatelogues']);
    Route::post('/manipulateAwaitingtimeSlot',[AwaitingSalesController::class,'manipulateAwaitingtimeSlots']);

    Route::post('/manipulateAwaitingSales',[AwaitingSalesController::class,'manipulateAwaiting']);
    Route::post('/catelogueClosureDetails',[AwaitingSalesController::class,'manipulateCatelogueClosureDetails']);    

    Route::get('/suppliments',[HighlightsDescriptionController::class,'getHighlightDescription']);
    Route::post('/manipulateHighlights',[HighlightsDescriptionController::class,'manipulateHighlightDesc']);

    Route::get('/holiday_notices',[HolidayNoticeController::class,'getHolidayNotice']);
    Route::post('/manipulateHolidayNotices',[HolidayNoticeController::class,'manipulateHolidayNotices']);

    Route::get('/awaitingSales1',[AwaitingSalesController::class,'getAwaiting1']);
    Route::post('/manipulateAwaitingLotsQtyDetails',[AwaitingSalesController::class,'manipulateAwaitingLotsQtyDetails']);
    Route::get('/awaitingSales2',[AwaitingSalesController::class,'getAwaiting2']);


    Route::get('/world-tea-production',[WorldTeaProductionController::class,'fetchWorldTeaProductionDetails']);
    
    Route::post('/manipulateWorldTeaProduction',[WorldTeaProductionController::class,'manipulateWorldTeaProductions']);

    Route::get('/add-page/{code?}',[AddNewPageController::class,'fetchNewPageDetails']);
    Route::post('/manipulateNewPageContent',[AddNewPageController::class,'manipulateNewPageContent']);

    // delete market report with all data
    Route::delete('/delete_report/{sale_code}',[DeleteMarketReportController::class,'deleteMarketReport']);

});