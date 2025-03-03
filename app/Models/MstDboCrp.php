<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstDboCrp extends Model
{
    use HasFactory;

    protected $table = 'mst_dbo_crp'; // Nama tabel

    protected $fillable = [
        'nm_category',
        'plan_actual',
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
        'grand_tot'
    ];

    // Relasi ke CrpSystem
    public function crpSystems()
    {
        return $this->hasMany(CrpSystem::class);
    }
}
