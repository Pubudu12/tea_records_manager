<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class market_analysis_main extends Model
{
    use HasFactory;

    protected $table = "market_analysis_main";

    public $fillable = [
        'sale_code',
        'market_analysis_tea_grade_id',
        'market_analysis_main_areas_id',
        'tea_grade_id',
        'description',
    ];
}
