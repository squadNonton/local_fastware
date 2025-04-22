<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstDboCrp extends Model
{
    protected $table = 'mst_dbo_crp';
    protected $fillable = [
        'nm_category',
        'month_1',
        'month_2',
        'month_3',
        'month_4',
        'month_5',
        'month_6',
        'month_7',
        'month_8',
        'month_9',
        'month_10',
        'month_11',
        'month_12',
        'plan_actual',
        'grand_tot',
    ];
}
