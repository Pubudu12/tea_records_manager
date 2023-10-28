<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class awaiting_lots_and_qty extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = "awaiting_lots_and_qty";

    public $fillable = [
        'sale_code',
        'ref_id',
        'lots_value',
        'quantity',
    ];
}
