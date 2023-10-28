<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class sri_lanka_tea_export_main extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'sri_lanka_tea_export_main';

    public $fillable = [
        'sale_code',
        'date',
        'source',
    ];
}
