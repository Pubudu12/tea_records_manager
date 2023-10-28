<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class order_of_sale_details extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = "order_of_sale_details";

    public $fillable = [
        'sale_code',
        'column_1_details',
        'column_2_details',
        'column_3_details',
        'type'
    ];
}
