<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class public_auction_sale_main extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'public_auction_sale_main';

    public $fillable = [
        'sales_code',
        'title',
        'date_in_text',
        'type',
    ];
}
