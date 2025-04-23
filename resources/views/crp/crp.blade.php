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
            <head>
                <meta name="csrf-token" content="{{ csrf_token() }}">
            </head>
            <div class="card shadow-lg rounded">
                <div class="card-body">
                    <p></p>
                    <h4 class="title text-center font-weight-bold text-primary">Tabel Summary</h4>
                    <h6 class="text-left font-weight-bold text-primary">
                        Partner user: {{ $userName }}
                    </h6>
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
                                    @for ($i = 0; $i < 12; $i++)
                                        <td><input type="text" class="form-control text-center" name="actual_values[]" 
                                            oninput="calculateYTD()"/>
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

                function saveData() {
                    const summaryData = [];
                    const summaryRows = document.querySelectorAll('#tabelsummary tbody tr');

                    for (let i = 0; i < summaryRows.length; i++) {
                        const planRow = summaryRows[i];
                        const categorySelect = planRow.querySelector('select');

                        if (!categorySelect) {
                            i++; // skip actual row
                            continue;
                        }

                        const category = categorySelect.value;
                        if (!category) continue;

                        // Only process Plan row
                        processRow(planRow, category, 'Plan', summaryData);

                        i++; // skip Actual row
                    }

                    const formData = new FormData();
                    formData.append('summary', JSON.stringify(summaryData));

                    fetch('{{ route('crp.store') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Data berhasil disimpan!');
                            resetInputs();
                        } else {
                            throw new Error(data.error || 'Data gagal disimpan');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error: ' + error.message);
                    });
                }


                function processRow(row, category, type, summaryData) {
                    const inputs = row.querySelectorAll('input[type="text"]');
                    const monthValues = Array.from(inputs).slice(0, 12).map(input => parseInt(input.value) || 0);
                    const ytd = parseInt(inputs[12]?.value) || 0;

                    const dataEntry = {
                        nm_category: category,
                        plan_actual: type,
                        grand_tot: ytd
                    };

                    for (let i = 0; i < 12; i++) {
                        dataEntry[`month_${i + 1}`] = monthValues[i] || 0;
                    }

                    summaryData.push(dataEntry);
                }
            </script>

        </section>

        <script>
            


        </script> 


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

                // Membuat baris Plan
                const newRowPlan = table.insertRow();
                
                // Checkbox
                const cellCheckbox = newRowPlan.insertCell();
                cellCheckbox.innerHTML = '<input type="checkbox" name="record1">';

                // Kategori (rowspan 2)
                const cellCategory = newRowPlan.insertCell();
                cellCategory.rowSpan = 2;
                cellCategory.innerHTML = `
                    <select class="form-control">
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
                `;

                // Tipe Plan
                const cellTypePlan = newRowPlan.insertCell();
                cellTypePlan.className = 'font-weight-bold text-primary';
                cellTypePlan.textContent = 'Plan';

                // Input bulan Jan-Dec untuk Plan
                for (let i = 0; i < 12; i++) {
                    const cell = newRowPlan.insertCell();
                    cell.innerHTML = `<input type="text" class="form-control text-center" name="plan_values[]" oninput="calculateYTD()">`;
                }

                // YTD Plan
                const cellYTDPlan = newRowPlan.insertCell();
                cellYTDPlan.innerHTML = '<input type="text" class="form-control text-center font-weight-bold" readonly>';

                // Membuat baris Actual
                const newRowActual = table.insertRow();

                // Cell kosong untuk checkbox (karena rowspan kategori)
                newRowActual.insertCell();

                // Tipe Actual
                const cellTypeActual = newRowActual.insertCell();
                cellTypeActual.className = 'font-weight-bold text-success';
                cellTypeActual.textContent = 'Actual';

                // Input bulan Jan-Dec untuk Actual
                for (let i = 0; i < 12; i++) {
                    const cell = newRowActual.insertCell();
                    cell.innerHTML = `<input type="text" class="form-control text-center" name="actual_values[]" oninput="calculateYTD()">`;
                }

                // YTD Actual
                const cellYTDActual = newRowActual.insertCell();
                cellYTDActual.innerHTML = '<input type="text" class="form-control text-center font-weight-bold" name="actual_ytd" readonly>';
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

            
        </script>


        <script>
            // Fungsi untuk menghitung YTD
            function calculateYTD() {
                const rows = document.querySelectorAll('#tabelsummary tbody tr');

                for (let i = 0; i < rows.length; i += 2) {
                    const planRow = rows[i];
                    const actualRow = rows[i + 1];

                    // --- Hitung YTD PLAN ---
                    let totalPlan = 0;
                    for (let col = 3; col < 15; col++) {
                        const input = planRow.cells[col].querySelector('input');
                        if (input) {
                            totalPlan += parseFloat(input.value) || 0;
                        }
                    }
                    const ytdPlanInput = planRow.cells[15]?.querySelector('input');
                    if (ytdPlanInput) ytdPlanInput.value = Math.round(totalPlan);

                    // --- Hitung YTD ACTUAL ---
                    let totalActual = 0;
                    for (let col = 2; col < 14; col++) {
                        const input = actualRow.cells[col]?.querySelector('input');
                        if (input) {
                            totalActual += parseFloat(input.value) || 0;
                        }
                    }
                    const ytdActualInput = actualRow.cells[14]?.querySelector('input[name="actual_ytd"]');
                    if (ytdActualInput) ytdActualInput.value = Math.round(totalActual);
                }
            }



            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('#tabelsummary tbody input[type="text"]').forEach(input => {
                    input.addEventListener('input', calculateYTD);
                });
            });

            
        </script>
    </main>
@endsection
