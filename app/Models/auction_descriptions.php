<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class auction_descriptions extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = "auction_descriptions";

    public $fillable = [
        'sale_code',
        'order',
        'description_title',
        'description',
        'type'
    ];
}
