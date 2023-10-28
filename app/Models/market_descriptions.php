<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class market_descriptions extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = "market_descriptions";

    public $fillable = [
        'elevation_id',
        'sales_code',
        'tea_grade',
        'description',
    ];
}
