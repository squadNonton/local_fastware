<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InquirySalesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
     * Mengambil data dari database untuk diekspor ke Excel.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return DB::table('inquiry_sales')
            ->join('detail_inquiry', 'inquiry_sales.id', '=', 'detail_inquiry.id_inquiry')
            ->select([
                DB::raw('ROW_NUMBER() OVER (ORDER BY inquiry_sales.created_at DESC) AS nomor_urut'),
                'inquiry_sales.id_customer', 'inquiry_sales.kode_inquiry', 'inquiry_sales.type_order',
                'inquiry_sales.jenis_inquiry', 'inquiry_sales.loc_imp', 'inquiry_sales.est_date',
                'inquiry_sales.supplier', 'inquiry_sales.create_by AS sales_person', 'inquiry_sales.progress',
                'inquiry_sales.refnopo AS ref_po', 'inquiry_sales.attach_file AS files', 'inquiry_sales.status',
                'inquiry_sales.created_at', 'inquiry_sales.updated_at', 'inquiry_sales.modified_by',
                'detail_inquiry.id_type AS raw_material', 'detail_inquiry.jenis AS shapes', 
                'detail_inquiry.thickness', 'detail_inquiry.inner_diameter', 'detail_inquiry.outer_diameter',
                'detail_inquiry.weight', 'detail_inquiry.length', 'detail_inquiry.qty AS qty_unit',
                'detail_inquiry.m1 AS forecast_month_1', 'detail_inquiry.m2 AS forecast_month_2', 
                'detail_inquiry.m3 AS forecast_month_3', 'detail_inquiry.so AS ref_so', 
                'detail_inquiry.ship AS ship_to', 'detail_inquiry.note AS remark', 'detail_inquiry.file',
                'detail_inquiry.created_at AS detail_created_at', 'detail_inquiry.updated_at AS detail_updated_at'
            ])
            ->get();
    }

    /**
     * Menentukan header untuk file Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'No.', 'Customer Name', 'Inquiry Code', 'Order Type', 'Inquiry Type', 'Category', 
            'Est. Date', 'Supplier', 'Sales Person', 'Progress', 'Ref. PO', 'Files', 'Status', 
            'Created_at', 'Updated_at', 'Modified_by', 'Raw Material', 'Shapes', 'Thickness', 
            'Inner Diameter', 'Outer Diameter', 'Weight', 'Length', 'Qty *Unit', 'Forecast Month 1', 
            'Forecast Month 2', 'Forecast Month 3', 'Ref. SO', 'Ship-To', 'Remark', 'File', 
            'Created_at (Detail)', 'Updated_at (Detail)'
        ];
    }

    /**
     * Mengatur gaya pada Excel.
     *
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Membuat baris pertama (heading) bold
        ];
    }

    /**
     * Memetakan data untuk ekspor ke Excel.
     *
     * @param object $inquiry
     * @return array
     */
    public function map($inquiry): array
    {
        return [
            $inquiry->nomor_urut, $inquiry->id_customer, $inquiry->kode_inquiry, $inquiry->type_order, 
            $inquiry->jenis_inquiry, $inquiry->loc_imp, $inquiry->est_date, $inquiry->supplier, 
            $inquiry->sales_person, $inquiry->progress, $inquiry->ref_po, $inquiry->files, 
            $inquiry->status, $inquiry->created_at, $inquiry->updated_at, $inquiry->modified_by,
            $inquiry->raw_material, $inquiry->shapes, $inquiry->thickness, $inquiry->inner_diameter, 
            $inquiry->outer_diameter, $inquiry->weight, $inquiry->length, $inquiry->qty_unit, 
            $inquiry->forecast_month_1, $inquiry->forecast_month_2, $inquiry->forecast_month_3, 
            $inquiry->ref_so, $inquiry->ship_to, $inquiry->remark, $inquiry->file, 
            $inquiry->detail_created_at, $inquiry->detail_updated_at
        ];
    }
}
