<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class market_analysis_main_areas extends Model
{
    use HasFactory;

    protected $table = "market_analysis_main_areas";

    public $fillable = [
        'id',
        'name',
        'code',
    ];
}
