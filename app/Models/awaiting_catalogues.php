<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class awaiting_catalogues extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = "awaiting_catalogues";

    public $fillable = [
        'sale_code',
        'type',
        'reference_awaiting_catalogue',
        'catelogue_values',
        'no_of_packages',
        'ctc',
    ];
}
