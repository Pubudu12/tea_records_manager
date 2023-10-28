<?php

use App\Http\Controllers\_PDF\Auction_highlights\AuctionHighlightsController;
use App\Http\Controllers\_PDF\Auction_highlights\AwaitingSummaryController;
use App\Http\Controllers\_PDF\Auction_highlights\MarketDashboardController;
use App\Http\Controllers\_PDF\Auction_highlights\OverallMarketController;
use App\Http\Controllers\_PDF\Auction_highlights\OverallMarketDetailsController;
use App\Http\Controllers\_PDF\Colombo_auctions\CropWeatherController;
use App\Http\Controllers\_PDF\Colombo_auctions\DateSettlementsController;
use App\Http\Controllers\_PDF\Colombo_auctions\OrderOfSaleController;
use App\Http\Controllers\_PDF\Colombo_auctions\TopPriceController;
use Illuminate\Support\Facades\Route;


Route::get('fetchMarketDashboardData',[MarketDashboardController::class,'fetchMarketDashboardDetails']);

Route::get('fetchOverallMarket',[OverallMarketController::class,'fetchOverallDetails']);

Route::get('fetchOverallMarketDetails',[OverallMarketDetailsController::class,'fetchOverallMarketDetails']);

Route::get('fetchAwaitingSummary',[AwaitingSummaryController::class,'fetchAwaitingSummary']);

Route::get('fetchAuctionDescriptions',[AuctionHighlightsController::class,'fetchAuctionDescriptions']);

Route::get('fetchCropWhetherDetails',[CropWeatherController::class,'fetchCropWhetherDetails']);

Route::get('fetchDateSettlements',[DateSettlementsController::class,'fetchDateSettlements']);

Route::get('fetchOrderOfSales',[OrderOfSaleController::class,'fetchOrderOfSales']);

Route::get('fetchTopPrices',[TopPriceController::class,'fetchTopPrices']);

?>