<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reference_srilankan_tea_exports extends Model
{
    use HasFactory;

    protected $table = 'reference_srilankan_tea_exports';

    public $fillable = [
        'id',
        'name',
    ];
}
