@extends('layout')

@section('content')
    <main id="main" class="main">

        <style>
            .card-title1 {
                text-align: center;
                width: 100%;
            }

            .swal2-popup {
                font-size: 0.6rem;
                width: 300px;
            }

            .searchable-dropdown {
                position: relative;
            }

            .searchable-dropdown input {
                width: 100%;
                box-sizing: border-box;
            }

            .dropdown-items {
                display: none;
                position: absolute;
                background-color: white;
                border: 1px solid #ddd;
                max-height: 200px;
                overflow-y: auto;
                z-index: 1000;
            }

            .dropdown-items div {
                padding: 8px;
                cursor: pointer;
            }

            .dropdown-items div:hover {
                background-color: #f1f1f1;
            }

            .font-sii {
                font-family: 'Cambria', serif;
                font-weight: bold;
            }

            .table-1 {
                margin: 5px auto;
                /* Pusatkan tabel */
                padding: 1rem;
                /* Padding di sekeliling tabel */
                background-color: #f7f7f7;
                /* Warna latar belakang */
                border-radius: 8px;
                /* Sudut membulat */
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                /* Bayangan untuk efek kedalaman */
            }

            .table-1 th {
                background-color: rgb(97, 97, 97);
                /* Warna latar belakang */
                color: #ffffff;
                font-size: 10pt;
                /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); */
                /* Bayangan untuk efek kedalaman */
                text-align: center;
                font-family: 'Cambria', serif;
            }

            .table-1 td {
                font-size: 8pt;
                font-family: 'Cambria', serif;
            }

            .datatable-table>tbody>tr>td {
                text-align: center;
            }


            .dataTable-pagination {
                padding: 0.25rem;
                /* Padding lebih kecil untuk pagination */
                font-size: 0.8rem;
                /* Ukuran font lebih kecil */
            }

            .dataTable-pagination .dataTable-info,
            .dataTable-pagination .dataTable-pagination-button {
                margin: 0;
                /* Hapus margin untuk elemen info dan tombol pagination */
            }

            .datatable-dropdown {
                font-family: 'Cambria', serif;
                font-size: 0.8rem;
            }

            .datatable-selector {
                padding: 0.2rem;
                /* Padding lebih kecil pada dropdown pagination */
                font-size: 0.8rem;
                /* Ukuran font lebih kecil */
                border-radius: 4px;
                /* Sudut membulat */
                border: 1px solid #ddd;
                /* Border untuk dropdown */
                font-family: 'Cambria', serif;
            }

            input[type="search"] {
                width: 100%;
                /* Lebar input pencarian */
                padding: 0.5rem;
                /* Padding untuk input */
                border: 1px solid #ddd;
                /* Border untuk input */
                border-radius: 10px;
                /* Sudut membulat untuk input */
                margin-bottom: 0.5rem;
                /* Jarak antara input dan tabel */
                transition: border-color 0.3s;
                /* Transisi saat berinteraksi */
                font-family: 'Cambria', serif;
            }

            input[type="search"] {
                padding: 0.3rem;
                /* Padding lebih kecil untuk input pencarian */
                font-size: 0.8rem;
                /* Ukuran font lebih kecil */
                border-radius: 10px;
                /* Sudut membulat */
                border: 1px solid #ddd;
                /* Border untuk input */
            }

            .dataTable-search {
                margin-bottom: 0.5rem;
                /* Jarak antara input pencarian dan tabel */
                font-family: 'Cambria', serif;
            }

            .modal {
                font-family: 'Cambria', serif;
                font-size: 0.9rem;
                font-weight: bold;
            }

            .modal-header {
                font-family: 'Cambria', serif;
                font-size: 0.7rem;
            }

            .testfont {
                font-family: 'Cambria', serif;
                font-size: 1rem;
            }

            .btn-custom-draft {
                background-color: #6c757d;
                /* atau warna lain yang Anda inginkan */
                color: white;
                font-size: 8pt;
                font-family: 'Cambria', serif;
                font-weight: bold;
            }

            .btn-custom-open {
                background-color: #00db37;
                /* atau warna lain */
                color: rgb(0, 0, 0);
                border: none;
                font-size: 8pt;
                font-family: 'Cambria', serif;
                font-weight: bold;
            }

            .btn-custom-approve-dept {
                background-color: #00cfeb;
                /* Warna kuning bisa jadi untuk approve ka.dept */
                color: black;
                border: none;
                font-size: 8pt;
                font-family: 'Cambria', serif;
                font-weight: bold;
            }

            .btn-custom-approve-dept:hover {
                background-color: #14b4c9;
                color: #ffffff;
            }

            .btn-custom-approve-sie {
                background-color: #00ffff;
                /* Warna biru bisa untuk approve ka.sie */
                color: rgb(0, 0, 0);
                border: none;
                font-size: 8pt;
                font-family: 'Cambria', serif;
                font-weight: bold;
            }

            .btn-custom-in-progress {
                background-color: #fbff07;
                /* Warna kuning tua untuk on progress */
                color: rgb(0, 0, 0);
                border: none;
                font-size: 8pt;
                font-family: 'Cambria', serif;
                font-weight: bold;
            }

            .btn-custom-finished {
                background-color: #00346b;
                /* Warna biru untuk finished */
                color: white;
                border: none;
                font-size: 8pt;
                font-family: 'Cambria', serif;
                font-weight: bold;
            }

            .btn-custom-rejected {
                background-color: #dc3545;
                /* Merah untuk rejected */
                color: white;
                border: none;
                font-size: 8pt;
                font-family: 'Cambria', serif;
                font-weight: bold;
            }

            .btn-custom-inventory {
                background-color: #00d39e;
                /* Merah untuk show form */
                color: #000000;
                border: none;
                font-size: 8pt;
                font-family: 'Cambria', serif;
                font-weight: bold;
            }

            .btn-custom-inventory:hover {
                background-color: #00ffbf;
                /* Merah untuk show form */
            }

            .btn-custom-form {
                background-color: #4df300;
                /* Merah untuk show form */
                font-size: 9pt;
                font-family: 'Cambria', serif;
                font-weight: bold;
            }

            .btn-custom-show {
                background-color: #f300a2;
                /* Merah untuk show form */
                font-size: 9pt;
                font-family: 'Cambria', serif;
                font-weight: bold;
            }

            .btn-custom-edit {
                background-color: #3564ff;
                /* Merah untuk show form */
                font-size: 9pt;
                font-family: 'Cambria', serif;
                font-weight: bold;
            }

            .btn-custom-view {
                background-color: #fffb00;
                /* Merah untuk show form */
                font-size: 9pt;
                font-family: 'Cambria', serif;
                font-weight: bold;
            }

            .btn-custom-delete {
                background-color: #ff0000;
                /* Merah untuk show form */
                font-size: 9pt;
                font-family: 'Cambria', serif;
                font-weight: bold;
            }

            .btn-custom-form:hover {
                background-color: #34a500;
                /* Merah untuk show form */
                font-size: 9pt;
                font-family: 'Cambria', serif;
                font-weight: bold;
            }

            .btn-custom-show:hover {
                background-color: #b10076;
                /* Merah untuk show form */
                font-size: 9pt;
                font-family: 'Cambria', serif;
                font-weight: bold;
            }

            .btn-custom-edit:hover {
                background-color: #0026a3;
                /* Merah untuk show form */
                font-size: 9pt;
                font-family: 'Cambria', serif;
                font-weight: bold;
            }

            .btn-custom-view:hover {
                background-color: #ffd000;
                /* Merah untuk show form */
                font-size: 9pt;
                font-family: 'Cambria', serif;
                font-weight: bold;
            }

            .btn-custom-delete:hover {
                background-color: #be0000;
                /* Merah untuk show form */
                font-size: 9pt;
                font-family: 'Cambria', serif;
                font-weight: bold;
            }

            .btn-stts {
                text-align: center;
            }
        </style>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-sii text-center">Overview Purchasing</h5>
                </div>

                <section class="section">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-1" id="overviewTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th class="text-center">Create By</th>
                                            <th class="text-center">Reference</th>
                                            <th class="text-center">Category</th>
                                            <th class="text-center">Supplier</th>
                                            <th class="text-center">Customer</th>
                                            <th>Status</th>
                                            <th>Ship-to</th>
                                            <th>Last Update</th>
                                            <th>Est. Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inquiries as $index => $inquiry)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td class="text-center">{{ $inquiry->create_by }}</td>
                                                <td class="text-center">{{ $inquiry->kode_inquiry }}</td>
                                                <td class="text-center">{{ $inquiry->loc_imp }}</td>
                                                <td class="text-center">{{ $inquiry->supplier }}</td>
                                                <td class="text-center">
                                                    {{ $inquiry->customer ? $inquiry->customer->name_customer : 'N/A' }}
                                                </td>
                                                @php
                                                    $statusDescriptions = [
                                                        1 => 'Draft',
                                                        2 => 'Open',
                                                        3 => 'Approve Ka.Dept',
                                                        4 => 'Approve Ka.Sie',
                                                        5 => 'On Progress',
                                                        6 => 'Finished',
                                                        7 => 'Rejected',
                                                        8 => 'Approve Inventory',
                                                        9 => 'Confirm Purchasing',
                                                    ];

                                                    // Mendefinisikan kelas tombol berdasarkan status
                                                    $buttonClasses = [
                                                        1 => 'btn-secondary', // Draft
                                                        2 => 'btn-success', // Open
                                                        3 => 'btn-danger', // Approve Ka.Dept
                                                        4 => 'btn-info', // Approve Ka.Sie
                                                        5 => 'btn-warning', // On Progress
                                                        6 => 'btn-primary', // Finished
                                                        7 => 'btn-danger', // Rejected
                                                        8 => 'btn-danger', // Approve Inventory
                                                        9 => 'btn-warning', // Confirm Purchasing
                                                    ];
                                                @endphp
                                                <td>
                                                    <button
                                                        class="btn btn-sm 
                                                        {{ $buttonClasses[$inquiry->status] ?? 'btn-light' }} 
                                                        {{ $inquiry->status == 1 ? 'btn-custom-draft' : '' }}
                                                        {{ $inquiry->status == 2 ? 'btn-custom-open' : '' }}
                                                        {{ $inquiry->status == 3 ? 'btn-custom-approve-dept' : '' }}
                                                        {{ $inquiry->status == 4 ? 'btn-custom-approve-sie' : '' }}
                                                        {{ $inquiry->status == 5 ? 'btn-custom-in-progress' : '' }}
                                                        {{ $inquiry->status == 6 ? 'btn-custom-finished' : '' }}
                                                        {{ $inquiry->status == 7 ? 'btn-custom-rejected' : '' }}
                                                        {{ $inquiry->status == 8 ? 'btn-custom-inventory' : '' }}
                                                        {{ $inquiry->status == 9 ? 'btn-custom-confirm-purchasing' : '' }}">
                                                        {{ $statusDescriptions[$inquiry->status] ?? 'Unknown' }}
                                                    </button>
                                                </td>
                                                <td>
                                                    @if ($inquiry->details->isNotEmpty())
                                                        @foreach ($inquiry->details as $detail)
                                                            <p>{{ $detail->ship }}</p>
                                                        @endforeach
                                                    @else
                                                        --- No Shipping Options ---
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $progress = App\Models\TrxDboProgPurchase::where(
                                                            'inquiry_id',
                                                            $inquiry->id,
                                                        )
                                                            ->latest()
                                                            ->first();
                                                    @endphp
                                                    {{ $progress ? $progress->description : 'No updates yet' }}
                                                </td>
                                                <td>{{ $inquiry->est_date }}</td>
                                                <td>
                                                    @if ($inquiry->status == 8)
                                                        <a href="#" class="btn btn-warning btn-sm"
                                                            onclick="confirmPurchasing({{ $inquiry->id }}); return false;"
                                                            title="Confirm Purchase">
                                                            <i class="bi bi-hand-index-thumb-fill"></i>
                                                        </a>
                                                    @endif

                                                    <a href="#" class="btn btn-primary btn-sm"
                                                        onclick="showEditDataModal({{ $inquiry->id }}, '{{ $inquiry->supplier }}', '{{ $inquiry->progress }}', '{{ $inquiry->est_date }}'); return false;"
                                                        title="Edit Inquiry">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-warning btn-sm"
                                                        onclick="showInquiry({{ $inquiry->id }}); return false;">
                                                        <i class="bi bi-eye-fill"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-primary btn-sm"
                                                        onclick="finishInquiry({{ $inquiry->id }}); return false;"
                                                        title="Finish Inquiry">
                                                        <i class="bi bi-emoji-sunglasses-fill"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Modal for Edit Supplier, Last Update, and Est. Date -->
                    <div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="editDataModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title testfont" id="editDataModalLabel">Edit Inquiry Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editDataForm">
                                        @csrf
                                        <input type="hidden" id="inquiryId" name="inquiry_id">

                                        <!-- Field Supplier (Dropdown List) -->
                                        <div class="mb-3">
                                            <label for="supplier" class="form-label">Supplier</label>
                                            <select class="form-select" id="supplier" name="supplier" required>
                                                <option value="">Select Supplier</option>
                                                <option value="PT. SINAR PUTRA METALINDO">
                                                    PT. SINAR PUTRA METALINDO</option>
                                                <option value="PT. TRUST STEEL INDO">
                                                    PT. TRUST STEEL INDO</option>
                                                <option value="PT. LUKWINDO NUSA DWIPA">
                                                    PT. LUKWINDO NUSA DWIPA</option>
                                                <option value="CV. BAJA MAKMUR">
                                                    CV. BAJA MAKMUR</option>
                                                <option value="CV. REIHAI ABADI METAL INDONESIA">
                                                    CV. REIHAI ABADI METAL INDONESIA</option>
                                                <option value="PT. SAMUDRA BAJA NUSANTARA">
                                                    PT. SAMUDRA BAJA NUSANTARA</option>
                                                <option value="PT. SURYA SEJAHTERA METALINDO LESTARI">
                                                    PT. SURYA SEJAHTERA METALINDO LESTARI</option>
                                                <option value="CV. DIMA RAMA SAKTI">
                                                    CV. DIMA RAMA SAKTI</option>
                                                <!-- Tambahkan opsi lain jika diperlukan -->
                                            </select>
                                        </div>

                                        <!-- Field Last Update (Free Text) -->
                                        <div class="mb-3">
                                            <label for="progress" class="form-label">Last Update</label>
                                            <input type="text" class="form-control" id="progress" name="progress"
                                                required>
                                        </div>

                                        <!-- Field Est. Date (Date Picker) -->
                                        <div class="mb-3">
                                            <label for="estDate" class="form-label">Est. Date <span>
                                                    (Incoming Shipment)</span></label>
                                            <input type="date" class="form-control" id="estDate" name="est_date"
                                                required>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        onclick="submitEditDataForm()">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </section>

        
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <!-- SimpleDataTables JS -->
        <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>

        <script>
            $(document).ready(function() {
                // Hover function for dropdowns
                $('.nav-item.dropdown').hover(function() {
                    $(this).find('.dropdown-menu').first().stop(true, true).slideDown(150);
                }, function() {
                    $(this).find('.dropdown-menu').first().stop(true, true).slideUp(150);
                });
            });

            $.noConflict();
            jQuery(document).ready(function($) {
                const dataTable = new simpleDatatables.DataTable("#overviewTable", {
                    searchable: true, // Aktifkan fitur pencarian
                    perPage: 10, // Jumlah entri data per halaman
                    perPageSelect: [5, 10, 20, 150], // Opsi jumlah entri data per halaman
                    dataProps: {
                        // Fungsi untuk menghasilkan format yang diinginkan
                        "Urutan": (value, data) => {
                            // Mendapatkan indeks baris data saat ini
                            const index = data.tableData.id;

                            // Mendapatkan nilai dari kolom "RO" atau "SPOR"
                            const spoOrRo = data[index][0].startsWith("RO") ? "RO" : "SPOR";

                            // Mendapatkan nilai dari kolom "Bulan"
                            const month = data[index][1];

                            // Mendapatkan nilai dari kolom "Tahun"
                            const year = data[index][2];

                            // Menghasilkan urutan sesuai format yang diinginkan
                            const order = (index + 1).toString().padStart(3, '0');
                            return `${spoOrRo}/${month}/${year}/${order}`;
                        }
                    }
                });
            });
        </script>



        <script>
            function confirmPurchasing(id) {
                // Tampilkan pertanyaan konfirmasi dengan SweetAlert
                Swal.fire({
                    title: 'Confirm',
                    text: "Are you sure?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes!',
                    cancelButtonText: 'No!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('confirmPurchase', '') }}/' + id,
                            method: 'POST',
                            data: {
                                '_token': '{{ csrf_token() }}' // CSRF token
                            },
                            success: function(response) {
                                Swal.fire('Sukses!', response.success, 'success').then(() => {
                                    location.reload(); // Reload halaman
                                });
                            },
                            error: function(xhr) {
                                console.error(xhr.responseText);
                                Swal.fire('Error!', xhr.responseJSON.error,
                                    'error'); // Tampilkan pesan error
                            }
                        });
                    } else {
                        Swal.fire('Canceled', 'Confirmation Canceled', 'info');
                    }
                });
            }

            function showEditDataModal(id, supplier, progress, estDate) {
                // Set inquiry_id
                document.getElementById('inquiryId').value = id;
                document.getElementById('supplier').value = supplier; // Set supplier
                document.getElementById('progress').value = progress; // Set last update
                document.getElementById('estDate').value = estDate; // Set est. date

                // Tampilkan modal
                var myModal = new bootstrap.Modal(document.getElementById('editDataModal'), {});
                myModal.show();
            }

            function submitEditDataForm() {
                const form = document.getElementById('editDataForm');
                const formData = new FormData(form);

                $.ajax({
                    url: '{{ route('updateInquiry') }}', // Route untuk update inquiry
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire('Success!', response.message, 'success').then(() => {
                            location.reload(); // Reload halaman
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error!', 'An error occurred while updating.', 'error');
                    }
                });
            }

            function finishInquiry(id) {
                // Menampilkan konfirmasi sebelum melanjutkan
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will mark the inquiry as finished.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, finish it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna mengkonfirmasi, lanjutkan dengan AJAX
                        $.ajax({
                            url: '{{ route('finishInquiry', '') }}/' + id, // Route untuk finishing inquiry
                            method: 'POST',
                            data: {
                                '_token': '{{ csrf_token() }}' // CSRF token
                            },
                            success: function(response) {
                                Swal.fire('Success!', 'Inquiry marked as finished.', 'success').then(() => {
                                    location.reload(); // Reload halaman untuk melihat update
                                });
                            },
                            error: function(xhr) {
                                console.error(xhr.responseText);
                                Swal.fire('Error!', 'An error occurred while finishing the inquiry.',
                                    'error');
                            }
                        });
                    }
                });
            }

            function showInquiry(id) {
                // Tampilkan detail inquiry dan tambahkan parameter query
                window.location.href = '{{ route('showFormSS', '') }}/' + id + '?source=approval';
            }
        </script>

    </main>
@endsection
