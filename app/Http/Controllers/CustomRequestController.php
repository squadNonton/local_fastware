<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomDboReq;
use Illuminate\Auth\Events\Validated;
use App\Models\Customer;

class CustomRequestController extends Controller
{
    public function showCstmReq()
    {
        $materials = CustomDboReq::with(['customers'])->get();
        $customers = Customer::all();

        return view('custom_req.showCstmReq', compact('materials', 'customers'));
    }

    public function createCstmReq(Request $request)
    {
        $request->validate([
            'sales' => 'required',
            'customer' => 'required',
        ]);
        
        // $request->validate([
        //     'sales' => 'required',
        //     'pt' => 'required',
        //     'ket_drawing' => 'required',
        //     'nama_project' => 'required',
        //     'progress' => 'required',
        //     'tgl_update' => 'required',
        //     'ref_so' => 'required',
        //     'remark' => 'requie|string|max:255',
        // ]);

        // // Debugging: Tampilkan semua data yang dikirim dari form
        // dd($request->all());

        CustomDboReq::create([
            'sales' => $request->sales,
            'customer' => $request->customer,
            'ket_drawing' => $request->ket_drawing,
            'nama_project' => $request->nama_project,
            'progress' => $request->progress,
            'tgl_update' => $request->tgl_update,
            'ref_so' => $request->ref_so,
            'remark' => $request->remark,
            'tgl_permintaan' => now(),
            'status' => 1,
        ]);

        return redirect()->back()->with('success', 'Material berhasil ditambahkan.');
    }

    public function deleteCstmReq($id)
    {
        $material = CustomDboReq::findOrFail($id);
        $material->delete();

        return redirect()->back()->with('success', 'Material berhasil dihapus.');
    }

    public function updateCstmReq(Request $request, $id)
    {
        $material = CustomDboReq::findOrFail($id);
        $material->update([
            'sales' => $request->sales,
            'customer' => $request->customer,
            'ket_drawing' => $request->ket_drawing,
            'nama_project' => $request->nama_project,
            'progress' => $request->progress,
            'tgl_update' => $request->tgl_update,
            'ref_so' => $request->ref_so,
            'remark' => $request->remark,
        ]);

        return redirect()->back()->with('success', 'Material berhasil diupdate.');
    }

}
