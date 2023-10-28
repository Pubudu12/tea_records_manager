<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class top_prices_regions extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = "top_prices_regions";

    public $fillable = [
        'region_name',
        'parent_id',
        'level',
        'code',
        'order',
    ];
}
