<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class major_importers_details extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = "major_importers_details";

    public $fillable = [
        'importers_main_id',
        'country_id',
        'bulk_tea',
        'packeted_tea',
        'tea_bags',
        'instant_tea',
        'green_tea',
        'total',
        'total_status'
    ];
}
