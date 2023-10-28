<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class overall_market extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = "overall_market";

    public $fillable = [
        'sales_code',
        'reference_overall_market_id',
        'quantity_m_kgs',
        'demand',
    ];
}
