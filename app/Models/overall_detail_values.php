<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class overall_detail_values extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = "overall_detail_values";

    public $fillable = [
        'sales_code',
        'reference_elevation',
        'overall_detail_values',
        'overall_status_values',
        'type',
    ];
}
