<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class srilankan_tea_exports_details extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'srilankan_tea_exports_details';

    public $fillable = [
        'reference_srilankan_tea_exports_id',
        'tea_export_main_id',
        'v_price',
        'value_price',
        'approx_price',
    ];
}
