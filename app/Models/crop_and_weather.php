<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class crop_and_weather extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'crop_and_weather';

    public $fillable = [
        'type',
        'sale_code',
        'date_duration',
        'title',
        'small_description',
        'weather'
    ];
}
