<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class public_auction_sale_monthly extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'public_auction_sale_monthly';

    public $fillable = [
        'sale_code',
        'ref_id',
        'monthly_price_lkr',
        'todate_price_lkr',
        'monthly_price_usd',
        'todate_price_usd',
        'value_status'
    ];
}
