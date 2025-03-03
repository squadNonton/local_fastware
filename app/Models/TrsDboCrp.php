<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrsDboCrp extends Model
{
    use HasFactory;

    protected $table = 'trs_dbo_crp'; // Nama tabel

    protected $fillable = [
        'mst_id', // Foreign Key ke mst_dbo_crp
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
        'total_cost_crp'
    ];

    // Relasi ke CrpSystem
    public function crpSystems()
    {
        return $this->hasMany(CrpSystem::class);
    }

    // Relasi ke MstDboCrp
    public function mstDboCrp()
    {
        return $this->belongsTo(MstDboCrp::class, 'mst_id');
    }
}
