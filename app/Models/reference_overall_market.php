<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reference_overall_market extends Model
{
    use HasFactory;

    protected $table = "reference_overall_market";

    public $fillable = [
        'name',
        'code',
    ];
}
