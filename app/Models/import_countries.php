<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class import_countries extends Model
{
    use HasFactory;

    protected $table = "import_countries";

    public $fillable = [
        'name',
        'code',
        'order',
    ];
}
