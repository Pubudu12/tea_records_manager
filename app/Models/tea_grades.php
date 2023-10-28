<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tea_grades extends Model
{
    use HasFactory;

    protected $table = 'tea_grades';

    public $fillable = [
        'name',
        'keyword',
        'code',
    ];
}
