<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DetailInquiry;
use App\Models\InquirySales;
use App\Models\TypeMaterial;
use App\Models\TrxDboProgPurchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PDF;

class InquirySalesController extends Controller
{
    public function createInquirySales()
    {
        $statuses = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $inquiries = InquirySales::with('customer')
            ->whereIn('status', $statuses)
            ->where('is_active', 1)
            ->orderByRaw('FIELD(status, 0, 1, 2, 3, 4, 5, 6, 7,8,9)')
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('kode_inquiry');

        $customers = Customer::all();

        return view('inquiry.create', compact('inquiries', 'customers'));
    }

        public function createInquirySales1()
    {
        $statuses = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

        // Update status dari 1 menjadi 2 sebelum mengambil data
        InquirySales::where('status', 1)->update(['status' => 2]);

        // Ambil data inquiry setelah update
        $inquiries = InquirySales::with('customer')
            ->whereIn('status', $statuses)
            ->where('is_active', 1)
            ->orderByRaw('FIELD(status, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9)')
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('kode_inquiry');

        $customers = Customer::all();

        return view('inquiry.create', compact('inquiries', 'customers'));
    }

    public function storeInquirySales(Request $request)
    {
        $request->validate([
            'jenis_inquiry' => 'required',
            'id_customer' => 'required',
            // 'supplier' => 'required',

        ]);

        // Generate inquiry code
        $jenisInquiry = $request->jenis_inquiry;
        $currentMonth = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y');

        // Ambil nomor urut
        $lastKodeInquiry = InquirySales::where('jenis_inquiry', $jenisInquiry)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->orderBy('kode_inquiry', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastKodeInquiry) {
            $lastKodeParts = explode('/', $lastKodeInquiry->kode_inquiry);
            $nextNumber = intval(end($lastKodeParts)) + 1;
        }

        $kodeInquiry = sprintf('%s/%02d/%04d/%03d', $jenisInquiry, $currentMonth, $currentYear, $nextNumber);

        // Simpan data inquiry baru
        $inquiry = new InquirySales();
        $inquiry->kode_inquiry = $kodeInquiry;
        $inquiry->jenis_inquiry = $jenisInquiry;
        $inquiry->id_customer = $request->id_customer;
        $inquiry->loc_imp = 'Local';
        // $inquiry->supplier = $request->supplier;
        // $inquiry->to_approve = 'Waiting';
        // $inquiry->to_validate = 'Waiting';
        $inquiry->status = 1;
        $inquiry->is_active = 1;
        $inquiry->create_by = Auth::user()->name;
        $inquiry->save();

        // Simpan progres awal sebagai "No updates yet"
        $progress = new TrxDboProgPurchase();
        $progress->inquiry_id = $inquiry->id;
        $progress->description = '---- No updates yet ----'; // Set default
        $progress->save();

        // Ketika membuat Inquiry
        TrxDboProgPurchase::create([
            'inquiry_id' => $inquiry->id,
            'user_id' => auth()->id(),
            'description' => 'Inquiry created.'
        ]);

        return redirect()->route('createinquiry')->with('success', 'Inquiry successfully saved.');
    }


    public function editInquiry($id)
    {
        // Temukan inquiry berdasarkan ID
        $inquiry = InquirySales::with('customer')->find($id); // Memuat customer bersamaan

        // Cek apakah inquiry ditemukan
        if (!$inquiry) {
            return response()->json(['error' => 'Inquiry not found'], 404);
        }

        // Ambil semua customers untuk populasi dropdown di form
        $customers = Customer::all();

        return response()->json([
            'id' => $inquiry->id,
            'kode_inquiry' => $inquiry->kode_inquiry,
            'jenis_inquiry' => $inquiry->jenis_inquiry,
            'id_customer' => $inquiry->id_customer,
            'customer_name' => $inquiry->customer->name_customer, // Pastikan relasi sudah ada
            'loc_imp' => $inquiry->loc_imp, // Pastikan relasi sudah ada
            // 'supplier' => $inquiry->supplier, // Ambil supplier dengan benar
            'customers' => $customers,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'jenis_inquiry' => 'required',
            'id_customer' => 'required',
            'loc_imp' => 'required',
            // 'supplier' => 'required',
        ]);

        // Temukan inquiry berdasarkan ID
        $inquiry = InquirySales::findOrFail($id);

        // Update field yang diperlukan
        $inquiry->jenis_inquiry = $request->jenis_inquiry; // Update jenis inquiry
        $inquiry->id_customer = $request->id_customer; // Update customer ID
        $inquiry->loc_imp = $request->loc_imp; // Update customer ID
        // $inquiry->supplier = $request->supplier; // Update supplier
        $inquiry->create_by = Auth::user()->name; // Update siapa yang membuat inquiry jika ikutan

        $inquiry->save(); // Simpan perubahan

        return redirect()->route('createinquiry')->with('success', 'Inquiry updated successfully');
    }


    public function delete($id)
    {
        // Temukan data berdasarkan ID
        $inquiry = InquirySales::findOrFail($id);
        // Ubah is_active menjadi 0
        $inquiry->is_active = 0; // Jadi tidak aktif
        $inquiry->save();

        return response()->json(['success' => 'Inquiry deleted successfully']);
    }

    public function formulirInquiry($id)
    {
        $inquiry = InquirySales::with('details.type_materials')->findOrFail($id);
        $materials = DetailInquiry::where('id_inquiry', $inquiry->id)->with('type_materials')->get();
        $typeMaterials = TypeMaterial::all();

        return view('inquiry.formulirInquiry', compact('inquiry', 'materials', 'typeMaterials'));
    }

    public function previewSS(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_inquiry' => 'required|integer',
            'materials' => 'required|array',
            'materials.*.id_type' => 'required|integer',
            'materials.*.jenis' => 'required|string',
            'materials.*.thickness' => 'nullable|string',
            'materials.*.weight' => 'nullable|string',
            'materials.*.inner_diameter' => 'nullable|string',
            'materials.*.outer_diameter' => 'nullable|string',
            'materials.*.length' => 'nullable|string',
            'materials.*.qty' => 'nullable|string',
            'materials.*.m1' => 'nullable|string',
            'materials.*.m2' => 'nullable|string',
            'materials.*.m3' => 'nullable|string',
            'materials.*.ship' => 'nullable|string',
            'materials.*.so' => 'required|string',
            'materials.*.note' => 'nullable|string',
            'materials.*.file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10048',
        ]);

        // Ambil id_inquiry dari request
        $id_inquiry = $request->id_inquiry;
        Log::info('ID Inquiry:', ['id_inquiry' => $id_inquiry]);

        // Ambil entri detail yang ada untuk inquiry
        $existingMaterials = DetailInquiry::where('id_inquiry', $id_inquiry)->get();

        // Iterasi dan simpan atau update material
        foreach ($request->materials as $material) {

            // Cek apakah material sudah ada
            $existingMaterial = $existingMaterials->where('id_type', $material['id_type'])->first();

            if ($existingMaterial) {
                // Jika sudah ada, update entri
                $existingMaterial->update([
                    'jenis' => $material['jenis'],
                    'thickness' => $material['thickness'],
                    'weight' => $material['weight'],
                    'inner_diameter' => $material['inner_diameter'],
                    'outer_diameter' => $material['outer_diameter'],
                    'length' => $material['length'],
                    'qty' => $material['qty'],
                    'm1' => $material['m1'],
                    'm2' => $material['m2'],
                    'm3' => $material['m3'],
                    'ship' => $material['ship'],
                    'so' => $material['so'],
                    'note' => $material['note']
                ]);
            } else {
                // Jika belum ada, simpan sebagai entri baru
                DetailInquiry::create([
                    'id_inquiry' => $id_inquiry,
                    'id_type' => $material['id_type'],
                    'jenis' => $material['jenis'],
                    'thickness' => $material['thickness'],
                    'weight' => $material['weight'],
                    'inner_diameter' => $material['inner_diameter'],
                    'outer_diameter' => $material['outer_diameter'],
                    'length' => $material['length'],
                    'qty' => $material['qty'],
                    'm1' => $material['m1'],
                    'm2' => $material['m2'],
                    'm3' => $material['m3'],
                    'ship' => $material['ship'],
                    'so' => $material['so'],
                    'note' => $material['note']
                ]);
            }
        }

        // Update status inquiry
        $inquiry = InquirySales::find($id_inquiry);
        if ($inquiry) {
            $inquiry->status = 1;
            $inquiry->save();
            Log::info('Inquiry status updated to 3', ['id' => $inquiry->id]);
        } else {
            Log::warning('Inquiry not found', ['id_inquiry' => $id_inquiry]);
            return response()->json(['message' => 'Inquiry not found'], 404);
        }

        // Ketika Inquiry Submitted
        TrxDboProgPurchase::create([
            'inquiry_id' => $inquiry->id,
            'user_id' => auth()->id(),
            'description' => 'Inquiry Submitted'
        ]);

        return response()->json(['message' => 'Detail Inquiry saved successfully']);
    }

    public function showFormSS(Request $request, $id)
    {
        $inquiry = InquirySales::with('details.type_materials')->findOrFail($id);

        // Fetch all detail inquiries based on id_inquiry from the main inquiry
        $materials = DetailInquiry::where('id_inquiry', $inquiry->id)->with('type_materials')->get();

        $typeMaterials = TypeMaterial::all(); // Ambil semua data TypeMaterial, sesuaikan dengan kebutuhan


        // Ambil semua nama file yang ter-upload
        $uploadedFiles = DetailInquiry::where('id_inquiry', $inquiry->id)
            ->pluck('file')
            ->flatMap(function ($file) {
                return json_decode($file) ?? []; // Kembalikan array kosong jika null
            })
            ->toArray();

        // $progressUpdates = TrxDboProgPurchase::where('inquiry_id', $id)->with('user')->get();
        $progressUpdates = TrxDboProgPurchase::where('inquiry_id', $id)
            ->with('user')
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan created_at menurun
            ->get();

        // Cek apakah berasal dari halaman approval
        $isFromApproval = request()->query('source') === 'approval';
        return view('inquiry.showFormSS', compact('inquiry', 'materials', 'typeMaterials', 'progressUpdates', 'uploadedFiles', 'isFromApproval'));
    }

    public function approveKaSie($id)
    {
        // Temukan inquiry berdasarkan ID
        $inquiry = InquirySales::findOrFail($id);

        // Ubah status inquiry menjadi 4 (Approve Ka.Sie)
        $inquiry->status = 4; // Menandakan status "Approve Ka.Sie"
        // Simpan ID pengguna yang melakukan approve
        $inquiry->kasie_id = Auth::user()->id; // Ambil ID pengguna yang login
        $inquiry->save();

        // Ketika menyetujui oleh Ka.Sie
        TrxDboProgPurchase::create([
            'inquiry_id' => $inquiry->id,
            'user_id' => auth()->id(),
            'description' => 'Approved by Ka. Sie.'
        ]);

        return redirect()->route('formulirInquiry', ['id' => $id])->with('success', 'Inquiry approved by Ka.Sie successfully.');
    }

    public function showApprovalKaSie()
    {
        // Ambil semua inquiry dengan status Open (2) dan yang belum disetujui
        $inquiries = InquirySales::with('customer')
            ->where('status', 2) // Hanya ambil yang berstatus Open
            ->where('is_active', 1) // Hanya yang aktif
            ->get();


        return view('inquiry.approvalKaSie', compact('inquiries'));
    }

    public function rejectKaSie($id)
    {
        // Temukan inquiry berdasarkan ID
        $inquiry = InquirySales::findOrFail($id);

        // Ubah status inquiry menjadi 5 (atau status yang relevan untuk rejected)
        $inquiry->status = 7; // Misalnya status ditandai sebagai rejected
        $inquiry->save();

        return response()->json(['success' => 'Inquiry rejected successfully.']);
    }

    public function showApprovalKaDept()
    {
        // Ambil semua inquiry dengan status Open (2) dan yang belum disetujui
        $inquiries = InquirySales::with('customer')
            ->where('status', 4) // Hanya ambil yang berstatus Open
            ->where('is_active', 1) // Hanya yang aktif
            ->get();

        return view('inquiry.approvalKaDept', compact('inquiries'));
    }

    public function approveKaDept($id)
    {
        // Temukan inquiry berdasarkan ID
        $inquiry = InquirySales::findOrFail($id);

        // Ubah status inquiry menjadi 3 (Approve Ka.Dept)
        $inquiry->status = 3; // Menandakan status "Approve Ka.Dept"
        // Simpan ID pengguna yang melakukan approve
        $inquiry->kadept_id = Auth::user()->id; // Ambil ID pengguna yang login
        $inquiry->save();

        // Ketika menyetujui oleh Ka.Dept
        TrxDboProgPurchase::create([
            'inquiry_id' => $inquiry->id,
            'user_id' => auth()->id(),
            'description' => 'Approved by Ka. Dept.'
        ]);

        return redirect()->route('showApprovalKaDept')->with('success', 'Inquiry approved successfully by Ka.Dept.');
    }

    public function rejectKaDept($id)
    {
        // Temukan inquiry berdasarkan ID
        $inquiry = InquirySales::findOrFail($id);

        // Ubah status inquiry menjadi 7 (Rejected)
        $inquiry->status = 7; // Menandakan status "Rejected"
        $inquiry->save();

        return redirect()->route('showApprovalKaDept')->with('success', 'Inquiry rejected successfully by Ka.Dept.');
    }

    public function showApprovalInventory()
    {
        // Ambil semua inquiry dengan status Open (2) dan yang belum disetujui
        $inquiries = InquirySales::with(['customer', 'details'])
            ->where('status', 3) // Hanya ambil yang berstatus Approve Ka.Dept
            ->where('is_active', 1) // Hanya yang aktif
            ->get();

        return view('inquiry.approvalInventory', compact('inquiries'));
    }

    public function approveInventory($id)
    {
        // Temukan inquiry berdasarkan ID
        $inquiry = InquirySales::findOrFail($id);

        // Ubah status inquiry menjadi 8 (Approve Inventory)
        $inquiry->status = 8; // Menandakan status "Approve Inventory"
        // Simpan ID pengguna yang melakukan approve
        $inquiry->inventory_id = Auth::user()->id; // Ambil ID pengguna yang login
        $inquiry->save();

        // Ketika menyetujui oleh Inventory
        TrxDboProgPurchase::create([
            'inquiry_id' => $inquiry->id,
            'user_id' => auth()->id(),
            'description' => 'Approved by Inventory.'
        ]);

        return redirect()->route('showApprovalInventory')->with('success', 'Inquiry approved successfully by Inventory.');
    }

    public function rejectInventory($id)
    {
        // Temukan inquiry berdasarkan ID
        $inquiry = InquirySales::findOrFail($id);

        // Ubah status inquiry menjadi 7 (Rejected)
        $inquiry->status = 7; // Menandakan status "Rejected"
        $inquiry->save();

        return redirect()->route('showApprovalInventory')->with('success', 'Inquiry rejected successfully by Inventory');
    }

    public function overviewPurchase()
    {
        // Ambil semua inquiry dengan status relevan
        $inquiries = InquirySales::with('customer')
            ->whereIn('status', [5, 6, 8, 9]) // Mengambil status On Progress, Finished, etc.
            ->where('is_active', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        $draftInquiries = InquirySales::with('customer')
            ->whereIn('status', [1, 2, 3, 4]) // Draft dan Open
            ->where('is_active', 1)
            ->get();

        return view('inquiry.overviewPurchase', compact('inquiries', 'draftInquiries'));
    }

    public function confirmPurchase($id)
    {
        // Temukan inquiry berdasarkan ID
        $inquiry = InquirySales::findOrFail($id);

        // Ubah status inquiry menjadi "Confirm Purchasing" (status 9)
        $inquiry->status = 9; // Menandakan status "Confirm Purchasing"
        $inquiry->purchasing_id = Auth::user()->id; // Ambil ID pengguna yang login
        $inquiry->save();

        // Ketika Confirm by Procurement
        TrxDboProgPurchase::create([
            'inquiry_id' => $inquiry->id,
            'user_id' => auth()->id(),
            'description' => 'Confirm Inquiry by Procurement.'
        ]);

        // Mengembalikan response sukses
        return response()->json(['success' => 'Inquiry confirmed for purchasing successfully.']);
    }

    public function updateInquiry(Request $request)
    {
        // Validasi input
        $request->validate([
            'inquiry_id' => 'required|integer|exists:inquiry_sales,id',
            'supplier' => 'required|string',
            'progress' => 'nullable|string',
            'refnopo' => 'nullable|string',
            'est_date' => 'nullable|date',
        ]);

        // Temukan inquiry berdasarkan ID
        $inquiry = InquirySales::findOrFail($request->inquiry_id);

        // Update data inquiry
        $inquiry->supplier = $request->supplier;
        $inquiry->progress = $request->progress;
        $inquiry->refnopo = $request->refnopo;
        $inquiry->est_date = $request->est_date;
        $inquiry->status = 5;
        $inquiry->save();

        // Simpan terakhir update ke tabel trx_dbo_progpurchase
        TrxDboProgPurchase::create([
            'inquiry_id' => $inquiry->id,
            'user_id' => auth()->id(), // Atau ID pengguna yang sesuai
            'description' => $request->progress,
        ]);

        return response()->json(['message' => 'Inquiry updated successfully.']);
    }

    public function updateInquiryDetails(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'materials.*.id_type' => 'required|integer',
        'materials.*.jenis' => 'required|string',
        'materials.*.thickness' => 'nullable|numeric',
        'materials.*.weight' => 'nullable|numeric',
        'materials.*.inner_diameter' => 'nullable|numeric',
        'materials.*.outer_diameter' => 'nullable|numeric',
        'materials.*.length' => 'nullable|numeric',
        'materials.*.qty' => 'required|integer',
        'materials.*.m1' => 'nullable|numeric',
        'materials.*.m2' => 'nullable|numeric',
        'materials.*.m3' => 'nullable|numeric',
        'materials.*.ship' => 'required|string',
        'materials.*.so' => 'nullable|string',
        'materials.*.note' => 'nullable|string',
    ]);

    // Temukan inquiry berdasarkan ID
    $inquiry = InquirySales::findOrFail($id);

    $updatedMaterials = [];

    // Update data materials
    foreach ($request->materials as $materialData) {
        $material = DetailInquiry::where('id_inquiry', $id)
            ->where('id_type', $materialData['id_type'])
            ->first();

        if ($material) {
            $jenis = $materialData['jenis'];

            // Perbarui hanya nilai yang sesuai dengan jenisnya
            $material->jenis = $jenis;
            $material->thickness = ($jenis === 'Flat') ? $materialData['thickness'] : null;
            $material->weight = ($jenis === 'Flat') ? $materialData['weight'] : null;
            $material->inner_diameter = ($jenis === 'Honed Tube') ? $materialData['inner_diameter'] : null;
            $material->outer_diameter = ($jenis === 'Round' || $jenis === 'Honed Tube') ? $materialData['outer_diameter'] : null;
            $material->length = $materialData['length'];
            $material->qty = $materialData['qty'];
            $material->m1 = $materialData['m1'];
            $material->m2 = $materialData['m2'];
            $material->m3 = $materialData['m3'];
            $material->ship = $materialData['ship'];
            $material->so = $materialData['so'];
            $material->note = $materialData['note'];
            $material->save();

            // Tambahkan data yang sudah diperbarui ke dalam array
            $updatedMaterials[] = $material;
        }
    }

    return response()->json([
        'success' => true,
        'message' => 'Data berhasil diperbarui!',
        'updatedMaterials' => $updatedMaterials // Kirim data terbaru ke frontend
    ]);

}

    // public function confirmPurchase($id)
    // {
    //     // Temukan inquiry berdasarkan ID
    //     $inquiry = InquirySales::findOrFail($id);

    //     // Pastikan status adalah "Approved Inventory" (status 8)
    //     if ($inquiry->status !== 8) {
    //         return response()->json(['error' => 'The inquiry is not approved by Inventory yet.'], 400);
    //     }

    //     // Ubah status inquiry menjadi "Confirm Purchasing" (status 9)
    //     $inquiry->status = 9; // Confirm Purchasing
    //     $inquiry->save();

    //     return response()->json(['success' => 'Inquiry confirmed for purchasing successfully.']);
    // }

    // public function storeProgressPurchase(Request $request)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'inquiry_id' => 'required|integer|exists:inquiry_sales,id',
    //         'progress_description' => 'required|string',
    //         'supplier' => 'required|string',
    //         'est_date' => 'nullable|date',
    //     ]);

    //     // Simpan data ke tabel trx_dbo_progpurchase
    //     $progressUpdate = new TrxDboProgPurchase();
    //     $progressUpdate->inquiry_id = $request->inquiry_id;
    //     $progressUpdate->user_id = Auth::id();
    //     $progressUpdate->description = $request->progress_description;
    //     $progressUpdate->save();

    //     // Update status inquiry menjadi "On Progress" (nilai 5)
    //     $inquiry = InquirySales::findOrFail($request->inquiry_id);
    //     $inquiry->supplier = $request->supplier;
    //     $inquiry->est_date = $request->est_date;
    //     $inquiry->status = 5; // On Progress
    //     $inquiry->purchasing_id = Auth::user()->id; // ID pengguna yang login
    //     $inquiry->save();

    //     return response()->json([
    //         'message' => 'Progress update saved successfully.',
    //         'inquiry' => $inquiry,
    //         'progress' => $progressUpdate
    //     ]);
    // }

    public function finishInquiry($id)
    {
        // Temukan inquiry berdasarkan ID
        $inquiry = InquirySales::findOrFail($id);

        // Ubah status inquiry menjadi "Finished" (status 6)
        $inquiry->status = 6; // Finished
        $inquiry->save();

        // Ketika Finished by Procurement
        TrxDboProgPurchase::create([
            'inquiry_id' => $inquiry->id,
            'user_id' => auth()->id(),
            'description' => 'Finished Inquiry by Procurement.'
        ]);

        return response()->json(['success' => 'Inquiry marked as finished.']);
    }

    public function showProgressHistory($id)
    {
        $inquiry = InquirySales::findOrFail($id);
        $progressUpdates = TrxDboProgPurchase::where('inquiry_id', $id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['inquiry' => $inquiry, 'progressUpdates' => $progressUpdates]);
    }

    public function generatePDF($id)
    {
        // Ambil data inquiry berdasarkan ID
        $inquiry = InquirySales::with(['details.type_materials', 'kasie', 'kadept', 'inventory', 'purchasing'])->findOrFail($id);
        $materials = DetailInquiry::where('id_inquiry', $inquiry->id)->with('type_materials')->get();

        // Ambil nama pengguna yang melakukan submit
        $submittedBy = $inquiry->create_by;

        // Ambil nama dari relasi
        $signatures = [
            'submitted' => $submittedBy,
            'approved_kasie' => $inquiry->kasie ? $inquiry->kasie->name : 'Waiting Approval',
            'approved_kadept' => $inquiry->kadept ? $inquiry->kadept->name : 'Waiting Approval',
            'approved_inventory' => $inquiry->inventory ? $inquiry->inventory->name : 'Waiting Approval',
            'confirmed_purchasing' => $inquiry->purchasing ? $inquiry->purchasing->name : 'Waiting Approval',
        ];

        // Konversi ke PDF dengan orientasi landscape
        $pdf = PDF::loadView('pdf.inquiry', compact('inquiry', 'materials', 'signatures'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('ADSI_FormInquiry.pdf');
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'id_inquiry' => 'required|exists:inquiry_sales,id', // Pastikan ID inquiry valid
            'attachments.*' => 'file|mimes:pdf,png,jpg,jpeg|max:10048', // Validasi file
        ]);

        // Simpan file yang di-upload
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                // Ambil nama asli file
                $filename = $file->getClientOriginalName();
                // Pindahkan file ke folder public/assets/inquiry
                $file->move(public_path('assets/inquiry'), $filename);

                // Cek apakah detail_inquiry dengan id_inquiry sudah ada
                $detail = DetailInquiry::where('id_inquiry', $request->id_inquiry)->first();

                if ($detail) {
                    // Jika sudah ada, tambahkan nama file ke kolom `file`
                    $currentFiles = $detail->file ? json_decode($detail->file) : []; // Mengambil file yang sudah ada
                    $currentFiles[] = $filename; // Tambahkan file baru

                    $detail->file = json_encode($currentFiles); // Simpan kembali ke kolom file
                    $detail->save();
                } else {
                    // Jika tidak ada, buat baris baru
                    DetailInquiry::create([
                        'id_inquiry' => $request->id_inquiry,
                        'file' => json_encode([$filename]), // Simpan sebagai array
                    ]);
                }
            }
        }

        // Ambil semua file yang terkait dengan id_inquiry
        $allFiles = DetailInquiry::where('id_inquiry', $request->id_inquiry)
            ->pluck('file')
            ->flatMap(function ($file) {
                return json_decode($file);
            })
            ->toArray();

        return response()->json(['message' => 'Files uploaded successfully', 'uploadedFiles' => $allFiles]);
    }

    public function show($id)
    {
        // Ambil inquiry dan materials
        $inquiry = InquirySales::findOrFail($id);
        $materials = DetailInquiry::where('id_inquiry', $inquiry->id)->with('type_materials')->get();

        // Ambil semua file yang di-upload terkait dengan id_inquiry
        $uploadedFiles = DetailInquiry::where('id_inquiry', $id)
            ->pluck('file')
            ->flatMap(function ($file) {
                return json_decode($file); // Mengonversi JSON ke array
            })->toArray();

        return view('showFormSS', compact('inquiry', 'materials', 'uploadedFiles'));
    }

    public function overviewInquiry()
    {

        // Ambil semua inquiry dengan status relevan
        $draftInquiries = InquirySales::with('customer')
            ->whereIn('status', [1, 2, 3, 4, 5, 6, 8, 9]) // Draft for Finish Process
            ->where('is_active', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('inquiry.overviewInquiry', compact('draftInquiries'));
    }


    public function createInquirySalesImport()
    {
        $statuses = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $inquiries = InquirySales::with('customer')
            ->whereIn('status', $statuses)
            ->where('is_active', 1)
            ->orderByRaw('FIELD(status, 0, 1, 2, 3, 4, 5, 6, 7,8,9)')
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('kode_inquiry');

        $customers = Customer::all();

        return view('inquiry.createImport', compact('inquiries', 'customers'));
    }
}
