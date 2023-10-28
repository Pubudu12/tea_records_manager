<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class market_analysis_details extends Model
{
    use HasFactory;

    protected $table = "market_analysis_details";

    public $fillable = [
        'market_analysis_column_row_set_id',
        'date',
        'value',
    ];
}
