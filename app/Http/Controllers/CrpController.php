<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Customer;
use App\Models\MstDboCrp;
use App\Models\TrsDboCrp;
use Illuminate\Support\Facades\DB;

class CrpController extends Controller
{
    public function index()
    {
        $userName = Auth::user()->name;

        // Mengambil data dari model MstDboCrp
        $mstDboCrps = MstDboCrp::where('partner_user', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Mengambil data dari model TrsDboCrp berdasarkan mst_id
        $mstIds = $mstDboCrps->pluck('id')->toArray();
        $trsDboCrps = TrsDboCrp::whereIn('mst_id', $mstIds)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('crp.crp', compact('mstDboCrps', 'trsDboCrps', 'userName'));
    }

    public function create()
    {
        // Tampilkan form untuk menambah data
        return view('crp.create'); // Buat view ini
    }

    // public function store(Request $request)
    // {
    //     // Validasi data yang diterima
    //     $validatedData = $request->validate([
    //         'plan_values' => 'required|array',
    //         'actual_values' => 'required|array',
    //         'plan_ytd' => 'required|numeric',
    //         'actual_ytd' => 'required|numeric',
    //     ]);

    //     // Simpan data summary
    //     foreach ($validatedData['summary'] as $summary) {
    //         $mstCrp = MstDboCrp::create([
    //             'nm_category' => $summary['nm_category'],
    //             'month_1' => $summary['plan_values'][0],
    //             'month_2' => $summary['plan_values'][1],
    //             'month_3' => $summary['plan_values'][2],
    //             'month_4' => $summary['plan_values'][3],
    //             'month_5' => $summary['plan_values'][4],
    //             'month_6' => $summary['plan_values'][5],
    //             'month_7' => $summary['plan_values'][6],
    //             'month_8' => $summary['plan_values'][7],
    //             'month_9' => $summary['plan_values'][8],
    //             'month_10' => $summary['plan_values'][9],
    //             'month_11' => $summary['plan_values'][10],
    //             'month_12' => $summary['plan_values'][11],
    //             'grand_tot' => $summary['ytd'], // Total YTD yang dihitung
    //             'plan_actual' => 'Plan', // Sesuaikan jika perlu
    //         ]);

    //         // Simpan data detail yang berkaitan dengan summary
    //         foreach ($validatedData['details'] as $detail) {
    //             TrsDboCrp::create([
    //                 'mst_id' => $mstCrp->id, // Menghubungkan ke summary yang baru dibuat
    //                 'nm_category' => $detail['category'],
    //                 'detail_activity' => $detail['detail_activity'],
    //                 'no_po' => $detail['no_PO'],
    //                 'date' => $detail['date'],
    //                 'qty' => $detail['qty'],
    //                 // Tambahkan data harga jika diperlukan
    //                 'price_before' => $detail['price_before'] ?? null, // tambahkan jika ada
    //                 'price_after' => $detail['price_after'] ?? null, // tambahkan jika ada
    //                 'price_sell' => $detail['price_sell'] ?? null, // tambahkan jika ada
    //                 'total_cost_before' => $detail['total_cost_before'] ?? null, // tambahkan jika ada
    //                 'total_cost_after' => $detail['total_cost_after'] ?? null, // tambahkan jika ada
    //                 'total_cost_crp' => $detail['total_cost_crp'] ?? null, // tambahkan jika ada
    //             ]);
    //         }
    //         return response()->json(['success' => true]);
    //     }
    // }



    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'summary' => 'required|string', // Validasi sebagai string JSON
        ]);

        // Decode JSON
        $summaryData = json_decode($request->summary, true);

        // Periksa apakah data valid
        if (!is_array($summaryData)) {
            return response()->json([
                'success' => false,
                'error' => 'Data summary tidak valid.'
            ], 400);
        }

        // Loop melalui setiap entri
        foreach ($summaryData as $entry) {
            // Pastikan nm_category dan plan_actual ada
            if (!isset($entry['nm_category']) || !isset($entry['plan_actual'])) {
                continue; // Lewati entri yang tidak valid
            }

            // Siapkan data untuk update atau create
            $data = [
                'month_1'     => $entry['month_1'] ?? 0,
                'month_2'     => $entry['month_2'] ?? 0,
                'month_3'     => $entry['month_3'] ?? 0,
                'month_4'     => $entry['month_4'] ?? 0,
                'month_5'     => $entry['month_5'] ?? 0,
                'month_6'     => $entry['month_6'] ?? 0,
                'month_7'     => $entry['month_7'] ?? 0,
                'month_8'     => $entry['month_8'] ?? 0,
                'month_9'     => $entry['month_9'] ?? 0,
                'month_10'    => $entry['month_10'] ?? 0,
                'month_11'    => $entry['month_11'] ?? 0,
                'month_12'    => $entry['month_12'] ?? 0,
                'grand_tot'   => $entry['grand_tot'] ?? 0,
                'partner_user' => Auth::user()->id,
            ];

            // Update atau create record berdasarkan nm_category, plan_actual, dan partner_user
            MstDboCrp::updateOrCreate(
                [
                    'nm_category'  => $entry['nm_category'],
                    'plan_actual'  => $entry['plan_actual'],
                    'partner_user' => Auth::user()->id,
                ],
                $data
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan.'
        ]);
    }

    public function savedetail(Request $request)
    {
        try {
            $rows = $request->input('rows');
            $userId = Auth::id();

            if (empty($rows)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No data provided to save.'
                ], 400);
            }

            DB::beginTransaction();

            foreach ($rows as $index => $row) {
                if (empty($row['actual_category'])) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Category is required for row " . ($index + 1)
                    ], 400);
                }

                $mstDboCrp = MstDboCrp::where('partner_user', $userId)
                    ->where('nm_category', $row['actual_category'])
                    ->first();

                if (!$mstDboCrp) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "No matching MstDboCrp record found for category: {$row['actual_category']} in row " . ($index + 1)
                    ], 400);
                }

                $data = [
                    'mst_id' => $mstDboCrp->id,
                    'nm_category' => $row['actual_category'],
                    'detail_activity' => $row['detail_activity'] ?? null,
                    'no_po' => $row['no_po'] ?? null,
                    'date' => $row['date'] ?? null,
                    'qty' => $row['qty'] ?? 0,
                    'price_before' => $row['price_before'] ?? 0,
                    'price_after' => $row['price_after'] ?? 0,
                    'selisih' => $row['selisih'] ?? 0,
                    'price_sell' => 0,
                    'total_cost_before' => $row['total_cost_before'] ?? 0,
                    'total_cost_after' => $row['total_cost_after'] ?? 0,
                    'total_cost_crp' => $row['total_cost_crp'] ?? 0,
                ];

                if (!empty($row['id'])) {
                    // Update existing record
                    $trsDboCrp = TrsDboCrp::find($row['id']);
                    if ($trsDboCrp) {
                        $trsDboCrp->update($data);
                    } else {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => "TrsDboCrp record with ID {$row['id']} not found in row " . ($index + 1)
                        ], 404);
                    }
                } else {
                    // Create new record
                    TrsDboCrp::create($data);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Data saved successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error saving TrsDboCrp: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }


    public function edit($id)
    {
        $mstDboCrp = MstDboCrp::findOrFail($id);
        return view('crp.edit', compact('mstDboCrp')); // Buat view ini
    }

    public function update(Request $request, $id)
    {
        // Validasi request
        $request->validate([
            'category' => 'required|string|max:255',
            'plan_actual' => 'required|string|max:10',
            // Tambahkan validasi untuk bulan-bulan lainnya
        ]);

        // Update data di database
        $mstDboCrp = MstDboCrp::findOrFail($id);
        $mstDboCrp->update($request->all());

        return redirect()->route('crp')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'categories' => 'required|array',
            'categories.*' => 'string',
        ]);

        $userId = Auth::user()->id;
        $categories = $request->categories;

        // Hapus record Plan dan Actual untuk kategori yang diberikan
        $deleted = MstDboCrp::where('partner_user', $userId)
            ->whereIn('nm_category', $categories)
            ->delete();

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Tidak ada data yang dihapus.'
            ], 400);
        }
    }

    public function delete(Request $request)
    {
        $ids = $request->input('ids'); // array berisi id plan dan actual
        if (!$ids || !is_array($ids)) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid.']);
        }
    
        // Soft delete
        MstDboCrp::whereIn('id', $ids)->update(['deleted_at' => now()]);
    
        return response()->json(['success' => true]);
    }

    public function deleteDetail(Request $request)
    {
        $ids = $request->input('ids'); // array berisi id plan dan actual
        if (!$ids || !is_array($ids)) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid.']);
        }
    
        // Soft delete
        TrsDboCrp::whereIn('id', $ids)->update(['deleted_at' => now()]);
    
        return response()->json(['success' => true]);
    }

}
