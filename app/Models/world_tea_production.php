<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class world_tea_production extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'world_tea_production';

    public $fillable = [
        'country',
        'sales_code',
        'selected_year',
        'selected_month',
        'current_year_price',
        'last_previous_years',
        'last_previous_years_difference',
        'current_previous_years',
        'current_previous_years_difference',
        'type'
    ];
}
