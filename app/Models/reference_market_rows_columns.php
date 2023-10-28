<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reference_market_rows_columns extends Model
{
    use HasFactory;

    protected $table = "reference_market_rows_columns";

    public $fillable = [
        'elevation_name',
        'code',
        'description_tea_grades',
        'table_columns',
        'table_rows',
    ];
}
