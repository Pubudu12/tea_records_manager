<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reference_awaiting_catelogues extends Model
{
    use HasFactory;

    protected $table = "reference_awaiting_catelogues";

    public $fillable = [
        'name',
        'code',
        'catelogue_references',
    ];
}
