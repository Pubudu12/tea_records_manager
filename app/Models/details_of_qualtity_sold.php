<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class details_of_qualtity_sold extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = "details_of_qualtity_sold";

    public $fillable = [
        'sale_code',
        'year',
        'quantity_m_kgs',
        'avg_price_lkr',
        'avg_price_usd'
    ];
}
