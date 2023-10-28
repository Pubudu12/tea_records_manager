<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reference_overall_elevations extends Model
{
    use HasFactory;

    protected $table = "reference_overall_elevations";

    public $fillable = [
        'name',
        'level',
        'code',
        'parent_category',
        'order',
        'column_includes',
        'columns'
    ];
}
