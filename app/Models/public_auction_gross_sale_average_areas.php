<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class public_auction_gross_sale_average_areas extends Model
{
    use HasFactory;

    protected $table = 'public_auction_gross_sale_average_areas';

    public $fillable = [
        'id',
        'name',
        'code',
    ];
}
