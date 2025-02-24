<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailInquiryImport extends Model
{
    use HasFactory;

    protected $table = 'detail_inquiry_import'; // Pastikan nama tabel benar
    protected $fillable = [
        'id_inquiry',
        'id_type',
        'nama_material',
        'jenis',
        'thickness',
        'inner_diameter',
        'outer_diameter',
        'weight',
        'length',
        'qty',
        'm1',
        'm2',
        'm3',
        'so',
        'konfirmasi',
        'nopo',
        'ship',
        'note',
        'file',
        'modified_by',
        'created_at',
        'updated_at',
        'customer',
        'progress',
        'est_date' 
    ];

    public function inquirySales1()
    {
        return $this->belongsTo(InquirySales::class);
    }

    public function type_materials(): BelongsTo
    {
        return $this->belongsTo(TypeMaterial::class, 'id_type');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'create_by');
    }
}
