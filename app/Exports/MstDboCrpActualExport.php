<?php

namespace App\Exports;

use App\Models\MstDboCrp;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class MstDboCrpActualExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = DB::table('mst_dbo_crp') // Ganti dengan nama tabel yang sesuai jika berbeda
            ->join('users', 'mst_dbo_crp.partner_user', '=', 'users.id') // Menyambungkan tabel mst_dbo_crp dengan users berdasarkan partner_user
            ->where('mst_dbo_crp.plan_actual', 'Actual')
            ->select('mst_dbo_crp.nm_category', 'users.name as user_name', 'mst_dbo_crp.month_1', 'mst_dbo_crp.month_2', 'mst_dbo_crp.month_3', 'mst_dbo_crp.month_4', 'mst_dbo_crp.month_5', 'mst_dbo_crp.month_6', 'mst_dbo_crp.month_7', 'mst_dbo_crp.month_8', 'mst_dbo_crp.month_9', 'mst_dbo_crp.month_10', 'mst_dbo_crp.month_11', 'mst_dbo_crp.month_12', 'mst_dbo_crp.grand_tot', 'mst_dbo_crp.id')
            ->get();

        $result = [];
        $no = 1;

        // Menambahkan kolom No pada setiap row data
        foreach ($data as $row) {
            $result[] = array_merge(
                ['No' => $no++], // Menambahkan nomor urut
                (array) $row // Mengonversi hasil row ke array
            );
        }

        return collect($result); // Mengembalikan collection agar dapat digunakan oleh Excel
    }

    /**
     * Menyediakan heading untuk kolom
     * @return array
     */
    public function headings(): array
    {
        return [
            'No', 'Category', 'User',
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',
            'Total', 'ID'
        ];
    }
}

