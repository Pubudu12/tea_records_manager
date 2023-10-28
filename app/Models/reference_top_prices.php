<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reference_top_prices extends Model
{
    use HasFactory;

    protected $table = "reference_top_prices";

    public $fillable = [
        'id',
        'list_order',
        'name',
        'code',
        'level',
        'parent_code',
    ];
}
