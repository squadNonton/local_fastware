@extends('layout')

@section('content')
    {{-- Style Css --}}
    <style>
        body {
            background-color: #f8f9fa;
        }

        .table-container {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        table {
            border-radius: 10px;
            overflow: hidden;
        }

        th {
            background-color: #007bff;
            color: white;
            text-align: center;
            font-weight: bold;
        }

        td,
        th {
            vertical-align: middle;
            text-align: center;
        }

        .plan-row {
            background-color: #e9f5ff;
        }

        .actual-row {
            background-color: #fff3e6;
        }

        .btn-custom {
            margin: 10px 5px;
            border-radius: 5px;
        }

        input[type="text"] {
            width: 80px;
            border: 1px solid #ccc;
            padding: 5px;
            border-radius: 5px;
            text-align: center;
        }

        select {
            width: 150px;
            padding: 5px;
            border-radius: 5px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .red-text {
            color: red;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .button-container button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 0 10px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        .button-container button:hover {
            background-color: #45a049;
        }

        .action-buttons button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            margin: 0 5px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
        }

        .action-buttons button:hover {
            background-color: #45a049;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: 100%;
            box-sizing: border-box;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fff;
        }
    </style>

    <main id="main" class="main">
        <section class="section">

            <div class="card shadow-lg rounded">
                <div class="card-body">
                    <p></p>
                    <h4 class="title text-center font-weight-bold text-primary">Tabel Summary</h4>
                    <div class="table-responsive">
                        <table id="tabelsummary" class="table table-striped table-bordered table-hover text-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width: 25px;"></th>
                                    <th style="width: 200px;">Category</th>
                                    <th>Type</th>
                                    <th>Jan</th>
                                    <th>Feb</th>
                                    <th>Mar</th>
                                    <th>Apr</th>
                                    <th>May</th>
                                    <th>Jun</th>
                                    <th>Jul</th>
                                    <th>Aug</th>
                                    <th>Sep</th>
                                    <th>Oct</th>
                                    <th>Nov</th>
                                    <th>Dec</th>
                                    <th>YTD</th>
                                </tr>
                            </thead>
                            <tbody id="summaryBody">
                                <tr>
                                    <td><input type="checkbox" name="record1"></td>
                                    <td rowspan="2">
                                        <select id="categorySelect" class="form-control">
                                            <option value="" disabled selected>Pilih Kategori</option>
                                            <option value="Consumable">Consumable</option>
                                            <option value="Subcont">Subcont</option>
                                            <option value="Repair Maintenance">Repair Maintenance</option>
                                            <option value="Utility">Utility</option>
                                            <option value="General Afffair">General Afffair</option>
                                            <option value="IT">IT</option>
                                            <option value="Material Cost">Material Cost</option>
                                            <option value="Indirect Material">Indirect Material</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </td>
                                    <td class="font-weight-bold text-primary">Plan</td>
                                    @for ($i = 0; $i < 12; $i++)
                                        <td><input type="text" class="form-control text-center" name="plan_values[]"
                                                oninput="calculateYTD()" /></td>
                                    @endfor

                                    <td><input type="text" class="form-control text-center font-weight-bold"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="font-weight-bold text-success">Actual</td>
                                    {{-- <td><input type="text" class="form-control text-center"></td>
                                        <td><input type="text" class="form-control text-center"></td>
                                        <td><input type="text" class="form-control text-center"></td>
                                        <td><input type="text" class="form-control text-center"></td>
                                        <td><input type="text" class="form-control text-center"></td>
                                        <td><input type="text" class="form-control text-center"></td>
                                        <td><input type="text" class="form-control text-center"></td>
                                        <td><input type="text" class="form-control text-center"></td>
                                        <td><input type="text" class="form-control text-center"></td>
                                        <td><input type="text" class="form-control text-center"></td>
                                        <td><input type="text" class="form-control text-center"></td>
                                        <td><input type="text" class="form-control text-center"></td>
                                        <td><input type="text" class="form-control text-center font-weight-bold"></td> --}}
                                    @for ($i = 0; $i < 12; $i++)
                                        <td><input type="text" class="form-control text-center" name="actual_values[]" />
                                        </td>
                                    @endfor
                                    <td><input type="text" class="form-control text-center font-weight-bold"
                                            name="actual_ytd" readonly /></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3 gap-2">
                        <a href="#" class="btn btn-success font-weight-bold px-4" onclick="addRow1()">
                            Tambah Baris
                        </a>
                        <a href="#" class="btn btn-danger font-weight-bold px-4" onclick="deleteRows1()">
                            Hapus Baris
                        </a>
                        <button class="btn btn-warning font-weight-bold px-4 text-white" onclick="resetInputs()">
                            Reset
                        </button>
                        <button class="btn btn-primary" onclick="saveData()">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
            <br> </br>


            {{-- <div class="card shadow-lg">
                <div class="card-body">
                    <p></p>
                    <div class="title text-center font-weight-bold text-primary">Detail Pencatatan Actual</div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center align-middle" id="actualTable">
                            <thead class="table-primary">
                                <tr>
                                    <th>
                                    </th>
                                    <th>Category</th>
                                    <th>Detail Activity</th>
                                    <th>No PO (optional)</th>
                                    <th>Date</th>
                                    <th>Qty</th>
                                    <th>Price Before</th>
                                    <th>Price After</th>
                                    <th>Total Cost Before</th>
                                    <th>Total Cost After</th>
                                    <th>CRP</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="checkbox" name="record"></td>
                                    <td>
                                        <select class="form-select" name="actual_category[]">
                                            <option value="Consumable">Consumable</option>
                                            <option value="Subcont">Subcont</option>
                                            <!-- Tambahkan opsi lain sesuai kebutuhan -->
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="detail_activity[]"></td>
                                    <td><input type="text" class="form-control" name="no_po[]"></td>
                                    <td><input type="date" class="form-control" name="date[]"></td>
                                    <td><input type="number" class="form-control" name="qty[]"
                                            oninput="calculateCRP(this)"></td>
                                    <td><input type="number" class="form-control" name="price_before[]"></td>
                                    <td><input type="number" class="form-control" name="price_after[]"></td>
                                    <td><input type="number" class="form-control" name="total_cost_before[]"></td>
                                    <td><input type="number" class="form-control" name="total_cost_after[]"></td>
                                    <td><input type="text" class="form-control crp" readonly></td>
                                </tr>
                                <!-- Tambahkan lebih banyak baris sesuai dengan kebutuhan -->
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3 gap-2">
                        <button class="btn btn-success" onclick="addRow()">
                            Tambah Baris
                        </button>
                        <button class="btn btn-danger" onclick="deleteRows()">
                            Hapus Baris
                        </button>
                        <button class="btn btn-warning text-white" onclick="resetInputs1()">
                            Reset
                        </button>
                        <button class="btn btn-primary" onclick="saveTable()">
                            Submit
                        </button>
                    </div>
                </div>
            </div> --}}

            <script>
                // function calculateCRP(input) {
                //     const row = input.closest('tr');
                //     const qty = parseFloat(row.querySelector('input[name="qty[]"]').value) || 0;
                //     const priceBefore = parseFloat(row.querySelector('input[name="price_before[]"]').value) || 0;
                //     const priceAfter = parseFloat(row.querySelector('input[name="price_after[]"]').value) || 0;

                //     // Hitungkan CRP (Anda perlu mendefinisikan bagaimana CRP dihitung)
                //     const crp = (priceAfter - priceBefore) * qty; // Contoh perhitungan CRP
                //     row.querySelector('.crp').value = crp.toFixed(2); // Modifikasi menyesuaikan hasil
                // }

                function calculateYTD() {
                    const planRows = document.querySelectorAll('#tabelsummary tbody tr');

                    planRows.forEach(row => {
                        const months = [];

                        // Hitung YTD untuk baris Plan
                        // Jika row memiliki lebih dari 15 sel
                        if (row.cells.length > 15) {
                            for (let i = 3; i < 15; i++) { // Index bulan Jan (3) hingga Des (14)
                                const monthValue = row.cells[i].querySelector('input');
                                if (monthValue) { // Pastikan monthValue tidak undefined
                                    months.push(parseFloat(monthValue.value) || 0);
                                }
                            }
                            const totalYTD = months.reduce((acc, value) => acc + value, 0);
                            const ytdInput = row.cells[15].querySelector('input');
                            if (ytdInput) { // Pastikan YTD input ada
                                ytdInput.value = totalYTD;
                            }
                        }
                    });
                }
            </script>
            <script>
                function addRow() {
                    const table = document.getElementById('actualTable').getElementsByTagName('tbody')[0];
                    const newRow = table.insertRow();

                    newRow.innerHTML = `
                <td><input type="checkbox" name="record"></td>
                <td>
                    <select>
                        <option value="Consumable">Consumable</option>
                        <option value="Subcont">Subcont</option>
                        <option value="Repair Maintenance">Repair Maintenance</option>
                        <option value="Utility">Utility</option>
                        <option value="General Afffair">General Afffair</option>
                        <option value="IT">IT</option>
                        <option value="Material Cost">Material Cost</option>
                        <option value="Indirect Material">Indirect Material</option>
                        <option value="Others">Others</option>
                    </select>
                </td>
                <td><input type="text" value=""></td>
                <td class="red-text"><input type="text" value=""></td>
                <td><input type="date" value=""></td>
                <td><input type="number" value=""></td>
                <td><input type="text" value=""></td>
                <td><input type="text" value=""></td>
                <td><input type="text" value=""></td>
                <td><input type="text" value=""></td>
                <td><input type="text" value=""></td>
                <td><input type="text" value=""></td>
            `;
                }

                function deleteRows() {
                    const table = document.getElementById('actualTable');
                    const checkboxes = table.querySelectorAll('input[name="record"]:checked');
                    checkboxes.forEach(checkbox => {
                        const row = checkbox.closest('tr');
                        if (row) {
                            row.remove();
                        }
                    });
                }

                function resetInputs1() {
                    document.querySelectorAll("#actualTable tbody input").forEach(input => {
                        if (input.type === "text" || input.type === "number" || input.type === "date") {
                            input.value = "";
                        }
                    });
                }
            </script>

        </section>

        {{-- <script>
            function saveData() {
                const summaryData = [];
                const detailData = [];

                // Ambil data dari tabel summary
                const summaryRows = document.querySelectorAll('#tabelsummary tbody tr');
                summaryRows.forEach(row => {
                    const category = row.querySelector('select').value;
                    const planValues = Array.from(row.querySelectorAll('input[type="text"]')).map(input => parseFloat(
                        input.value) || 0);
                    const ytd = row.querySelector('td:last-child input').value;

                    if (category) {
                        summaryData.push({
                            nm_category: category,
                            plan_values: planValues,
                            ytd: ytd
                        });
                    }
                });

                // Ambil data dari tabel detail
                const detailRows = document.querySelectorAll('#actualTable tbody tr');
                detailRows.forEach(row => {
                    const category = row.querySelector('select').value;
                    const detailActivity = row.querySelector('input[type="text"]').value;
                    const noPO = row.querySelectorAll('input[type="text"]')[1].value;
                    const date = row.querySelector('input[type="date"]').value;
                    const qty = row.querySelector('input[type="number"]').value;

                    if (category) {
                        detailData.push({
                            category: category,
                            detail_activity: detailActivity,
                            no_PO: noPO,
                            date: date,
                            qty: qty,
                            // Kirim harga dan total cost jika diperlukan
                        });
                    }
                });

                // Kirim semua data ke backend
                fetch('{{ route('crp.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            summary: summaryData,
                            details: detailData
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Data berhasil disimpan!');
                            resetInputs(); // Atur ulang input
                        } else {
                            alert('Data gagal disimpan.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        </script> --}}


        {{-- Tabel SummaryJSQ --}}

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
        </script>

        <script>
            function addRow1() {
                const table = document.getElementById('tabelsummary').getElementsByTagName('tbody')[0];

                const newRowPlan = table.insertRow();
                const newRowActual = table.insertRow();

                newRowPlan.innerHTML = `
                <td><input type="checkbox" name="record1"></td>
                <td rowspan="2">
                    <select>
                        <option value="Consumable">Consumable</option>
                        <option value="Subcont">Subcont</option>
                        <option value="Repair Maintenance">Repair Maintenance</option>
                        <option value="Utility">Utility</option>
                        <option value="General Afffair">General Afffair</option>
                        <option value="IT">IT</option>
                        <option value="Material Cost">Material Cost</option>
                        <option value="Indirect Material">Indirect Material</option>
                        <option value="Others">Others</option>
                    </select>
                </td>
                <td>Plan</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            `;

                newRowActual.innerHTML = `
                <td></td>
                <td>Actual</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            `;
            }

            function deleteRows1() {
                const checkboxes = document.querySelectorAll('input[name="record1"]:checked');
                checkboxes.forEach(checkbox => {
                    const row = checkbox.closest('tr');
                    if (row) {
                        row.nextElementSibling?.remove(); // Hapus baris Actual jika ada
                        row.remove();
                    }
                });
            }

            function resetInputs() {
                document.querySelectorAll("#tabelsummary tbody input[type='text']").forEach(input => {
                    input.value = "";
                });
            }

            function saveData() {
                const summaryData = [];
                const detailData = [];

                // Ambil data dari tabel summary
                const summaryRows = document.querySelectorAll('#tabelsummary tbody tr:first-child');

                summaryRows.forEach(row => {
                    const category = row.querySelector('select').value || ''; // Jika null, isi dengan string kosong
                    const planValues = Array.from(row.querySelectorAll('input[name="plan_values[]"]')).map(input => {
                        return parseFloat(input.value) || 0; // Jika input tidak valid, isi dengan 0
                    });
                    const ytd = parseFloat(row.querySelector('input[name="plan_ytd"]').value) ||
                        0; // Menambahkan penanganan null

                    summaryData.push({
                        nm_category: category,
                        plan_values: planValues,
                        ytd: ytd
                    });
                });

                // Ambil data dari tabel detail
                const detailRows = document.querySelectorAll('#actualTable tbody tr');
                detailRows.forEach(row => {
                    const category = row.querySelector('select[name="actual_category[]"]');
                    const detailActivity = row.querySelector('input[name="detail_activity[]"]');
                    const noPO = row.querySelector('input[name="no_po[]"]');
                    const date = row.querySelector('input[name="date[]"]');
                    const qty = row.querySelector('input[name="qty[]"]');
                    const priceBefore = row.querySelector('input[name="price_before[]"]');
                    const priceAfter = row.querySelector('input[name="price_after[]"]');

                    // Mengambil nilai dan memastikan tidak ada yang null
                    const categoryValue = category ? category.value : ''; // Kategori
                    const detailActivityValue = detailActivity ? detailActivity.value : ''; // Detail Activity
                    const noPOValue = noPO ? noPO.value : ''; // No PO
                    const dateValue = date ? date.value : ''; // Date
                    const qtyValue = qty ? parseFloat(qty.value) : 0; // Qty, default 0
                    const priceBeforeValue = priceBefore ? parseFloat(priceBefore.value) : 0; // Price Before
                    const priceAfterValue = priceAfter ? parseFloat(priceAfter.value) : 0; // Price After

                    detailData.push({
                        category: categoryValue,
                        detail_activity: detailActivityValue,
                        no_PO: noPOValue,
                        date: dateValue,
                        qty: qtyValue,
                        price_before: priceBeforeValue,
                        price_after: priceAfterValue,
                        // Tambahkan total cost atau CRP jika perlu
                    });
                });

                // Kirim data ke backend
                fetch('{{ route('crp.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            summary: summaryData,
                            details: detailData
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Data berhasil disimpan!');
                            resetInputs(); // Atur ulang input setelah simpan
                        } else {
                            alert('Data gagal disimpan.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        </script>


        <script>
            // Fungsi untuk menghitung YTD
            function calculateYTD() {
                const planRows = document.querySelectorAll('#tabelsummary tbody tr');
                planRows.forEach(row => {
                    const months = [];
                    for (let i = 3; i < 15; i++) { // Indeks 3 hingga 14 untuk bulan Jan-Dec
                        const monthValue = row.cells[i].querySelector('input').value;
                        months.push(parseFloat(monthValue) || 0);
                    }
                    const totalYTD = months.reduce((acc, value) => acc + value, 0);
                    row.cells[15].querySelector('input').value = totalYTD; // Cell index 14 untuk YTD
                });
            }


            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('#tabelsummary tbody input[type="text"]').forEach(input => {
                    input.addEventListener('input', calculateYTD);
                });
            });

            // Fungsi untuk menyimpan data
            // function saveData() {
            //     const category = document.getElementById('categorySelect').value;
            //     const monthInputs = document.querySelectorAll('#tabelsummary tbody tr:first-child input[type="text"]');

            //     const planValues = Array.from(monthInputs).map(input => input.value);

            //     const ytd = document.querySelector('#tabelsummary tbody tr:first-child td:last-child input').value;

            //     // Kirim data ke backend menggunakan Fetch API
            //     fetch('{{ route('crp.store') }}', {
            //             method: 'POST',
            //             headers: {
            //                 'Content-Type': 'application/json',
            //                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
            //             },
            //             body: JSON.stringify({
            //                 nm_category: nm_category,
            //                 plan_actual: plan_actual,
            //                 jan: planValues[0],
            //                 feb: planValues[1],
            //                 mar: planValues[2],
            //                 apr: planValues[3],
            //                 may: planValues[4],
            //                 jun: planValues[5],
            //                 jul: planValues[6],
            //                 aug: planValues[7],
            //                 sep: planValues[8],
            //                 oct: planValues[9],
            //                 nov: planValues[10],
            //                 dec: planValues[11],
            //                 ytd: ytd
            //             })
            //         })
            //         .then(response => response.json())
            //         .then(data => {
            //             if (data.success) {
            //                 alert('Data berhasil disimpan!');
            //                 resetInputs(); // Atur ulang inputs setelah simpan
            //             } else {
            //                 alert('Data gagal disimpan.');
            //             }
            //         })
            //         .catch(error => {
            //             console.error('Error:', error);
            //         });
            // }

            //
        </script>
    </main>
@endsection
