<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $value = session()->get('SelectedSaleCode');

        $menuArr = array(
            [
                'name' => 'Home',
                'link' => '/reportDashboard',
                'maxRole' => 'all',
                'category' => 'general',
                'activeID' => 'home'
            ],
            [
                'name' => 'Auction Highlights',
                'link' => '#',
                'maxRole' => 'all',
                'category' => 'report',
                'sub' => [
                    // [
                    //     'name' => 'Update Report',
                    //     'link' => '/update/'
                    // ],
                    [
                        'name' => 'Market Dashboard',
                        'link' => '/market-dashboard',
                        'activeID' => 'marketDashboard'
                    ],      
                    [
                        'name' => 'Overall Market',
                        'link' => '/overall-market',
                        'activeID' => 'overallMarket'
                    ],               
                    [
                        'name' => 'Highlights',
                        'link' => '/auction-descriptions',
                        'activeID' => 'auctionDescriptions'
                    ],
                    [
                        'name' => 'Add New Page',
                        'link' => '/add-page/AUCTION_HIGHLIGHTS',
                        'activeID' => 'addNewPageForAuctionHighlights'
                    ],
                    [
                        'name' => 'View PDF',
                        'link' => '/generateAuctionHighlights/html',
                        'activeID' => 'viewPreview'
                    ],
                    [
                        'name' => 'Download PDF',
                        'link' => '/generateAuctionHighlights/pdf',
                        'activeID' => 'generatePDF',
                        'target' => '_blank'
                    ],
                ]
            ],

            [
                'name' => 'Colombo Auctions',
                'link' => '#',
                'maxRole' => 'all',
                'category' => 'report',
                'sub' => [
                    [
                        'name' => 'Order Of Sales',
                        'link' => '/order-of-sales',
                        'activeID' => 'orderOfSales',
                    ],
                    [
                        'name' => 'Crop & Weather',
                        'link' => '/crop-and-weather',
                        'activeID' => 'cropAndWeather',
                    ],
                    [
                        'name' => 'High Grown Tea Market',
                        'link' => '/market-analysis/HIGH_GROWN',
                        'activeID' => 'highGrown',
                    ],
                    [
                        'name' => 'Medium Grown Tea Market',
                        'link' => '/market-analysis/MEDIUM_GROWN',
                        'activeID' => 'mediumGrown',
                    ],
                    [
                        'name' => 'Unorthodox Tea Market',
                        'link' => '/market-analysis/UNORTHODOX',
                        'activeID' => 'unorthodox',
                    ],
                    [
                        'name' => 'Off Grade Tea Market',
                        'link' => '/market-analysis/OFF_GRADES',
                        'activeID' => 'offGrades',
                    ],
                    [
                        'name' => 'Dust Tea Market',
                        'link' => '/market-analysis/DUSTS',
                        'activeID' => 'dusts',
                    ],
                    [
                        'name' => 'Low Grown Tea Market',
                        'link' => '/market-analysis/LOW_GROWN',
                        'activeID' => 'lowGrown',
                    ],
                    [
                        'name' => 'Top Prices',
                        'link' => '/top-prices',
                        'activeID' => 'topPrices',
                    ],
                    [
                        'name' => 'Add New Page',
                        'link' => '/add-page/COLOMBO_AUCTIONS',
                        'activeID' => 'addPageForColomboAuctions',
                    ],

                ]
            ],

            [
                'name' => 'Tea Statistics',
                'link' => '#',
                'maxRole' => 'all',
                'category' => 'report',
                'sub' => [
                    [
                        'name' => 'Quantity Sold',
                        'link' => '/qualtity-sold',
                        'activeID' => 'quantitySold'
                    ],
                    [
                        'name' => 'Rates of Exchange',
                        'link' => '/rates-of-exchange',
                        'activeID' => 'ratesOfExchange'
                    ],
                    [
                        'name' => 'National Tea Sales Average',
                        'link' => '/national-tea-average',
                        'activeID' => 'nationalTeaAverage'
                    ],
                    [
                        'name' => 'Weekly Tea Sales Average',
                        'link' => '/weekly-tea-sales-average',
                        'activeID' => 'weeklyTeaSalesAvg'
                    ],
                    [
                        'name' => 'Monthly Tea Sales Average',
                        'link' => '/monthly-tea-sales-average',
                        'activeID' => 'monthlyTeaSalesAvg'
                    ],
                    [
                        'name' => 'National Tea Production',
                        'link' => '/national-tea-production',
                        'activeID' => 'nationalTeaProduction'
                    ],
                    [
                        'name' => 'Sri Lankan Tea Production',
                        'link' => '/sri-lanka-tea-production',
                        'activeID' => 'sriLankaTeaProduction'
                    ],
                    [
                        'name' => 'National Tea Exports',
                        'link' => '/national-tea-exports',
                        'activeID' => 'nationalTeaExports'
                    ],
                    [
                        'name' => 'Sri Lanka Tea Exports',
                        'link' => '/sri-lanka-tea-exporters',
                        'activeID' => 'sriLankaTeaExporters'
                    ],
                    [
                        'name' => 'Major Tea Importes of Sri Lanka',
                        'link' => '/major-importers',
                        'activeID' => 'majorImporters'
                    ],
                    [
                        'name' => 'World Tea Production',
                        'link' => '/world-tea-production',
                        'activeID' => 'worldTeaProduction'
                    ],
                    [
                        'name' => 'Awaiting Sales 1',
                        'link' => '/awaitingSales1',
                        'activeID' => 'awaitingSales1'
                    ],
                    [
                        'name' => 'Awaiting Sales 2',
                        'link' => '/awaitingSales2',
                        'activeID' => 'awaitingSales2'
                    ],
                    [
                        'name' => 'Add New Page',
                        'link' => '/add-page/TEA_STATISTICS',
                        'activeID' => 'addNewPageForTeaStatistics'
                    ],
                ]
            ],

            [
                'name' => 'World Tea Auctions',
                'link' => '#',
                'maxRole' => 'all',
                'category' => 'report',
                'sub' => [
                    [
                        'name' => 'World Tea Descriptions',
                        'link' => '/world-tea-descriptions',
                        'activeID' => 'world-tea-descriptions'
                    ],
                    [
                        'name' => 'Add New Page',
                        'link' => '/add-page/WORLD_TEA_AUCTIONS',
                        'activeID' => 'addNewPageForWorldTeaAuctions'
                    ],
                ]
            ],

            [
                'name' => 'Suppliments',
                'link' => '#',
                'maxRole' => 'all',
                'category' => 'report',
                'sub' => [
                    [
                        'name' => 'Suppliments',
                        'link' => '/suppliments',
                        'activeID' => 'suppliments'
                    ],
                    [
                        'name' => 'Holiday Notices',
                        'link' => '/holiday_notices',
                        'activeID' => 'holiday_notices'
                    ],
                    [
                        'name' => 'Add New Page',
                        'link' => '/add-page/SUPPLIMENTS',
                        'activeID' => 'addNewPageForSuppliments'
                    ],
                ]
            ],

            [
                'name' => 'References',
                'link' => '#',
                'maxRole' => 'all',
                'category' => 'general',
                'sub' => [
                    [
                        'name' => 'Countries',
                        'link' => '/countries',
                        'activeID' => 'countries'
                    ],

                    // [
                    //     'name' => 'Tea Grades',
                    //     'link' => '/tea-grades'
                    // ],

                    [
                        'name' => 'Brokers',
                        'link' => '/vendors',
                        'activeID' => 'vendors'
                    ],

                    // [
                    //     'name' => 'Marks',
                    //     'link' => '/regions'
                    // ],
                ]
            ],

            [
                'name' => 'Users',
                'link' => '#',
                'maxRole' => 'all',
                'category' => 'general',
                'sub' => [
                    [
                        'name' => 'User List',
                        'link' => '/users',
                        'activeID' => 'users'
                    ],
                    // [
                    //     'name' => 'User Actions',
                    //     'link' => '/userActions'
                    // ],
                ]
            ],
        );

        View::share('globalMenuArr', $menuArr);

    }
}
