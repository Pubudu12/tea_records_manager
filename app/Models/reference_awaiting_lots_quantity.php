<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reference_awaiting_lots_quantity extends Model
{
    use HasFactory;

    protected $table = "reference_awaiting_lots_quantity";

    public $fillable = [
        'name',
        'code',
        'ref_order',
        'type',
    ];
}
