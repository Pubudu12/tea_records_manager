<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class public_auction_sale_details extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'public_auction_sale_details';

    public $fillable = [
        'sale_code',
        'reference_id',
        'public_auction_main_id',
        'price_lkr',
        'lkr_status',
        'todate_price_lkr',
        'todate_lkr_status',
        'price_usd',
        'usd_status',
        'todate_price_usd',
        'todate_usd_status'
    ];
}
