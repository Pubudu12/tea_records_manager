<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reference_world_tea_production extends Model
{
    use HasFactory;

    protected $table = "reference_world_tea_production";

    public $fillable = [
        'id',
        'name',
        'code',
        'type'
    ];
}
