@extends('layout')

@section('content')

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
        td, th {
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
    input[type="text"], input[type="number"], input[type="date"] {
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
                    <tbody>
                        <tr>
                            <td><input type="checkbox" name="record1"></td>
                            <td rowspan="2">
                                <select class="form-control">
                                    <option value="1">Kategori 1</option>
                                    <option value="2">Kategori 2</option>
                                    <option value="3">Kategori 3</option>
                                    <option value="4">Kategori 4</option>
                                    <option value="5">Kategori 5</option>
                                    <option value="6">Kategori 6</option>
                                    <option value="7">Kategori 7</option>
                                </select>
                            </td>
                            <td class="font-weight-bold text-primary">Plan</td>
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
                            <td><input type="text" class="form-control text-center"></td>
                            <td><input type="text" class="form-control text-center font-weight-bold"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="font-weight-bold text-success">Actual</td>
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
                            <td><input type="text" class="form-control text-center"></td>
                            <td><input type="text" class="form-control text-center font-weight-bold"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
    
            <div class="d-flex justify-content-center mt-3 gap-2">
                <a href="#" class="btn btn-success font-weight-bold px-4" onclick="addRow1()">Tambah Baris</a>
                <a href="#" class="btn btn-danger font-weight-bold px-4" onclick="deleteRows1()">Hapus Baris</a>
                <button class="btn btn-warning font-weight-bold px-4 text-white" onclick="resetInputs()">Reset</button>
            </div>
        </div>
    </div>
    
    
    <script>
        function addRow1() {
            const table = document.getElementById('tabelsummary').getElementsByTagName('tbody')[0];
    
            const newRowPlan = table.insertRow();
            const newRowActual = table.insertRow();
    
            newRowPlan.innerHTML = `
                <td><input type="checkbox" name="record1"></td>
                <td rowspan="2">
                    <select>
                        <option value="1">Kategori 1</option>
                        <option value="2">Kategori 2</option>
                        <option value="3">Kategori 3</option>
                        <option value="4">Kategori 4</option>
                        <option value="5">Kategori 5</option>
                        <option value="6">Kategori 6</option>
                        <option value="7">Kategori 7</option>
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
    </script>
    

    <br> </br>


    <div class="card shadow-lg">
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
                            <th class="red-text">No PO (optional)</th>
                            <th>Date</th>
                            <th>Qty</th>
                            <th colspan="3">Price / Unit</th>
                            <th colspan="3">Total Cost</th>
                        </tr>
                        <tr>
                            <th style="width: 25px;"></th>
                            <th style="width: 200px;"></th>
                            <th style="width: 200px;"></th>
                            <th style="width: 100px;"></th>
                            <th style="width: 25px;"></th>
                            <th style="width: 100px;"></th>
                            <th style="width: 100px;">Before</th>
                            <th style="width: 100px;">After</th>
                            <th style="width: 100px;">Selisih</th>
                            <th style="width: 100px;">Before</th>
                            <th style="width: 100px;">After</th>
                            <th style="width: 100px;">CRP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="checkbox" name="record">
                            </td>
                            <td>
                                <select class="form-select">
                                    <option value="1">Kategori 1</option>
                                    <option value="2">Kategori 2</option>
                                    <option value="3">Kategori 3</option>
                                    <option value="4">Kategori 4</option>
                                    <option value="5">Kategori 5</option>
                                    <option value="6">Kategori 6</option>
                                    <option value="7">Kategori 7</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" value=""></td>
                            <td class="red-text"><input type="text" class="form-control" value=""></td>
                            <td><input type="date" class="form-control" value=""></td>
                            <td><input type="number" class="form-control" value=""></td>
                            <td><input type="text" class="form-control" value=""></td>
                            <td><input type="text" class="form-control" value=""></td>
                            <td><input type="text" class="form-control" value=""></td>
                            <td><input type="text" class="form-control" value=""></td>
                            <td><input type="text" class="form-control" value=""></td>
                            <td><input type="text" class="form-control" value=""></td>
                        </tr>
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
            </div>
        </div>
    </div>
    
    
    <script>
        function addRow() {
            const table = document.getElementById('actualTable').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow();
    
            newRow.innerHTML = `
                <td><input type="checkbox" name="record"></td>
                <td>
                    <select>
                        <option value="1">Kategori 1</option>
                        <option value="2">Kategori 2</option>
                        <option value="3">Kategori 3</option>
                        <option value="4">Kategori 4</option>
                        <option value="5">Kategori 5</option>
                        <option value="6">Kategori 6</option>
                        <option value="7">Kategori 7</option>
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
    


        <button class="btn btn-primary" onclick="saveTable()">Submit</button>
    
</section>

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

</main>

@endsection