<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\ReferenceTopPrices;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            ReferenceTopPrices::class,
            months::class,
            quantitySoldRows::class,
            referenceAwaitingCatelogues::class,
            referenceAwaitingLotsAndQty::class,
            referencePublicAuctionSales::class,
            ReferenceTopPrices::class,
            refMarketRowsColumns::class,
            RefSriLankanTeaExports::class,
            ReferenceSriLankanTeaProduction::class,
        ]);

    }
}
