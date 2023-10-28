<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class months extends Model
{
    use HasFactory;

    protected $table = 'months';

    public $fillable = [
        'id',
        'name',
        'code',
    ];
}
