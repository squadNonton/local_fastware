<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Customer;
use App\Models\MstDboCrp;
use App\Models\TrsDboCrp;

class CrpController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;

        // Mengambil data dari model
        $mstDboCrps = MstDboCrp::all();

        return view('crp.crp', compact('mstDboCrps'));
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
    $validated = $request->validate([
        'summary' => 'required|string', // Validasi sebagai string JSON
    ]);

    $summaryData = json_decode($request->summary, true);

    if (!is_array($summaryData)) {
        return response()->json([
            'success' => false,
            'error' => 'Data summary tidak valid.'
        ], 400);
    }

    foreach ($summaryData as $entry) {
        MstDboCrp::create([
            'nm_category' => $entry['nm_category'],
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
            'plan_actual' => $entry['plan_actual'], // Pastikan nilai Plan/Actual
            'grand_tot'   => $entry['grand_tot'] ?? 0,
        ]);
    }

    return response()->json(['success' => true]);
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

    public function destroy($id)
    {
        $mstDboCrp = MstDboCrp::findOrFail($id);
        $mstDboCrp->delete();

        return redirect()->route('crp')->with('success', 'Data berhasil dihapus!');
    }
}
