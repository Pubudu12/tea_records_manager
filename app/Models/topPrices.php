<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class topPrices extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'top_prices';

    public $fillable = [
        'sale_code',
        'reference_code',
        'mark_name',
        'mark_code',
        'varities',
        'is_forbes',
        'asterisk',
        'value',
    ];
}
