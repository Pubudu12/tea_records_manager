<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class top_prices_detail extends Model
{
    use HasFactory;

    protected $table = 'top_prices_detail';

    public $fillable = [
        'sale_code',
        'top_prices_regions_id',
        'price',
        'status',
    ];
}
