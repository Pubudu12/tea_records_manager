<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class tea_market_descriptions extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = "tea_market_descriptions";

    public $fillable = [
        'sales_code',
        'title',
        'small_description',
        'description',
    ];
}
