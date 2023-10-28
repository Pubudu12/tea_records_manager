<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reference_public_auction_sales extends Model
{
    use HasFactory;

    protected $table = "reference_public_auction_sales";

    public $fillable = [
        'name',
        'code',
        'type'
    ];
}
