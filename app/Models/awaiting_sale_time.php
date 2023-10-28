<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class awaiting_sale_time extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = "awaiting_sale_time";

    public $fillable = [
        'sale_code',
        'type',
        'date',
        'elevation',
        'time'
    ];
}
