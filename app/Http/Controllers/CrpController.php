<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Customer;
use App\Models\MstDboCrp;

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

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nm_category' => 'required|string|max:255',
            'month_1' => 'required|numeric',
            'month_2' => 'required|numeric',
            'month_3' => 'required|numeric',
            'month_4' => 'required|numeric',
            'month_5' => 'required|numeric',
            'month_6' => 'required|numeric',
            'month_7' => 'required|numeric',
            'month_8' => 'required|numeric',
            'month_9' => 'required|numeric',
            'month_10' => 'required|numeric',
            'month_11' => 'required|numeric',
            'month_12' => 'required|numeric',
            'grand_tot' => 'required|numeric',
        ]);

        // Simpan data ke database
        MstDboCrp::create([
            'category' => $request->category,
            'month_1' => $request->month_1,
            'month_2' => $request->month_2,
            'month_3' => $$request->month_3,
            'month_4' => $request->month_4,
            'month_5' => $request->month_5,
            'month_6' => $request->month_6,
            'month_7' => $request->month_7,
            'month_8' => $request->month_8,
            'month_9' => $request->month_9,
            'month_10' => $request->month_10,
            'month_11' => $request->month_11,
            'month_12' => $request->month_12,
            'grand_tot' => $request->ytd, // Total bisa disesuaikan jika butuh perhitungan lain
            'plan_actual' => 'Plan', // Sesuaikan jika perlu
        ]);

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
