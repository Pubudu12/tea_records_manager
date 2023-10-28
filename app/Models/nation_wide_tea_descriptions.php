<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class nation_wide_tea_descriptions extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = "nation_wide_tea_descriptions";

    public $fillable = [
        'sales_code',
        'title',
        'description',
        'type'
    ];
}
