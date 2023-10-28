<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class sales_list extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    
    protected $table = 'sales_list';
    protected $primaryKey = 'sales_id';

    public $fillable = [
        'sales_id',
        'sales_code',
        'title',
        'sales_no',
        'year',
        'month',
        'current_dollar_value',
        'report_day_one',
        'report_day_two',
        'awaiting_scheduled_day_one',
        'awaiting_scheduled_day_two',
        'buyers_prompt_date',
        'sellers_prompt_date',
        'published',
        'published_date'
    ];
}
