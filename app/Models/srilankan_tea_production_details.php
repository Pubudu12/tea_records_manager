<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class srilankan_tea_production_details extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'srilankan_tea_production_details';

    public $fillable = [
        'reference_tea_production_id',
        'month',
        'year',
        'sale_code',
        'comparing_years',
        'ctc_price',
        'ctc_price_status',
        'ctc_change_actual_price',
        'ctc_change_actual_status',
        'ctc_change_percent_price',
        'ctc_change_percent_status',
        'orthodox_price',
        'orthodox_status',
        'orthodox_change_actual_price',
        'orthodox_change_actual_status',
        'orthodox_change_percent_price',
        'orthodox_change_percent_status',
        'total',
        'total_status',
        'total_change_actual_price',
        'total_change_actual_status',
        'total_change_percent_price',
        'total_change_percent_status'
    ];
}
