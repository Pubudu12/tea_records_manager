<?php

use App\Http\Controllers\APIs\AuctionHighlightsAPIController;
use App\Http\Controllers\APIs\ColomboAuctionsAPIController;
use App\Http\Controllers\APIs\TeaStatisticsAPIController;
use App\Http\Controllers\auctionHighlights\AuctionHighlightsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('market_report/{sale_code}',[AuctionHighlightsAPIController::class,'fetchMarketReportMainDetails']);

Route::get('market_dashboard/{sale_code}',[AuctionHighlightsAPIController::class,'fetchMarketDashboard']);

Route::get('overall_market/{sale_code}',[AuctionHighlightsAPIController::class,'fetchOverall']);

Route::get('overall_market_details/{sale_code}',[AuctionHighlightsAPIController::class,'fetchOverallDetails']);

Route::get('auction_descriptions/{sale_code}',[AuctionHighlightsAPIController::class,'auctionDescriptions']);

Route::get('order_of_details/{sale_code}',[ColomboAuctionsAPIController::class,'orderOfSales']);

Route::get('date_settlements/{sale_code}',[ColomboAuctionsAPIController::class,'dateSettlements']);

Route::get('crop_and_weather/{sale_code}',[ColomboAuctionsAPIController::class,'fetchCropANdWeather']);

Route::get('merket_descriptions/{sale_code}/{elevation_code}',[ColomboAuctionsAPIController::class,'fetchMarketDescriptions']);

Route::get('merket_analysis/{sale_code}/{elevation_code}',[ColomboAuctionsAPIController::class,'fetchMarketAnalysisDetails']);

Route::get('top_prices/{sale_code}',[ColomboAuctionsAPIController::class,'fetchTopPrices']);

Route::get('quality_sold_details/{sale_code}',[TeaStatisticsAPIController::class,'fetchQualitySold']);

Route::get('rates_of_exchange/{sale_code}',[TeaStatisticsAPIController::class,'fetchRatesOfExchanges']);

Route::get('public_auction_weekly/{sale_code}',[TeaStatisticsAPIController::class,'fetchWeekyPublicSales']);

Route::get('public_auction_monthly/{sale_code}',[TeaStatisticsAPIController::class,'fetchMonthlyPublicSales']);

Route::get('nation_wide_descriptions/{sale_code}',[TeaStatisticsAPIController::class,'fetchNationWideDescriptions']);

Route::get('tea_exports/{sale_code}',[TeaStatisticsAPIController::class,'fetchTeaExports']);

Route::get('fetch_awaiting_catalogues/{sale_code}',[TeaStatisticsAPIController::class,'fetchAwaitingCatalogues']);

Route::get('fetch_awaiting_2/{sale_code}',[TeaStatisticsAPIController::class,'fetchAwaiting_2']);

Route::get('srilankan_tea_production/{sale_code}',[TeaStatisticsAPIController::class,'fetchSriLankanTeaProduction']);

Route::get('tea_market_descriptions/{sale_code}',[TeaStatisticsAPIController::class,'fetchWorldTeaDescriptions']);

Route::get('tea_market_descriptions/{sale_code}',[TeaStatisticsAPIController::class,'fetchWorldTeaDescriptions']);

// Route::get('tea_market_descriptions/{sale_code}',[TeaStatisticsAPIController::class,'fetchWorldTeaDescriptions']);
