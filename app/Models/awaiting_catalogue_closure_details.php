<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class awaiting_catalogue_closure_details extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = "awaiting_catalogue_closure_details";

    public $fillable = [
        'sale_code',
        'days_in_text',
        'month',
        'year',
        'sale_number',
        'small_description',
    ];
}
