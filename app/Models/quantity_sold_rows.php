<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quantity_sold_rows extends Model
{
    use HasFactory;

    protected $table = 'quantity_sold_rows';

    public $fillable = [
        'id',
        'row_name',
        'code',
    ];
}
