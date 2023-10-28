<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class rates_of_exchange extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'rates_of_exchange';

    public $fillable = [
        'id',
        'sales_code',
        'small_description',
        'year',
        'usd',
        'stg_pd',
        'euro',
        'yuan',
        'source_text'
    ];
}
