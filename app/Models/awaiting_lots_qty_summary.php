<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class awaiting_lots_qty_summary extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = "awaiting_lots_qty_summary";

    public $fillable = [
        'sales_code',
        'lots',
        'reprints_lots',
        'quantity',
        'reprints_qty',
    ];
}
