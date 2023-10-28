<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class quantity_sold_summary extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'quantity_sold_summary';

    public $fillable = [
        'id',
        'sales_code',
        'quantity_sold_row_id',
        'date',
        'year',
        'weekly_price_kgs',
        'todate_price_kgs',
        'type'
    ];
}
