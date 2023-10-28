<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class awaiting_sales_main extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'awaiting_sales_main';

    public $fillable = [
        'sale_code',
        'first_date',
        'second_date',
        'number_of_pkgs',
        'ctc',
        'buyers_promt_date',
        'sellers_promt_date',
        'lots_summary',
        're_print_lots_summary',
        'quality_summary',
        're_print_quality_summary'
    ];
}
