<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrsDboCrp extends Model
{
    protected $table = 'trs_dbo_crp';
    protected $fillable = [
        'mst_id',
        'nm_category',
        'detail_activity',
        'no_po',
        'date',
        'qty',
        'price_before',
        'price_after',
        'price_sell',
        'total_cost_before',
        'total_cost_after',
        'total_cost_crp',
    ];
}
