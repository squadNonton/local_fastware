<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry PDF</title>
    <style>
        @page {
            margin: 1cm;

            /* Margin 1cm di semua sisi */
        }

        body {
            font-family: 'Cambria', serif;
            padding-right: 2rem;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            display: flex;
            /* Menggunakan flexbox untuk layout */
            align-items: center;
            /* Menyelaraskan item secara vertikal di tengah */
            justify-content: flex-start;
            /* Mengatur agar gambar dan teks dimulai dari kiri */
            margin-bottom: 30px;
            /* Margin bawah untuk jarak */
        }

        .header img {
            width: 20%;
            /* Lebar gambar yang diinginkan */
            height: auto;
            /* Memastikan aspek rasio terjaga */
            margin-right: 20px;
            /* Jarak antara gambar dan teks */
        }

        .header h1 {
            margin: 0;
            /* Menghapus margin default */
            text-align: center;
            /* Menyelaraskan teks ke tengah */
            flex-grow: 1;
            /* Memungkinkan teks untuk mengambil ruang yang tersisa */
        }

        .header-info {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            /* Membagi menjadi 5 kolom */
            gap: 10px;
            /* Jarak antar kolom */
            margin-bottom: 20px;
            /* Jarak antara header dan tabel */
        }

        .header-info div {
            text-align: left;
            /* Rata kiri untuk teks */
            margin-top: 3px;
        }

        .header-info label {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 0.85rem;
            /* Memperkecil ukuran font tabel */
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 2px;
            /* Mengurangi padding untuk memperkecil tabel */
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        h2 {
            margin-top: 20px;
            /* Jarak atas untuk Signature Details */
        }

        .table-n {
            border: none;
        }

        .table-n1 {
            border: none;
            background-color: transparent;
        }

        p {
            font-family: 'Cambria', serif;
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 1%;

        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/img/AdasiLogo.png') }}" alt="">
            <h1>Detail Inquiry</h1>
        </div>

        <table class="table-n">
            <thead class="table-n">
                <tr class="table-n">
                    <th style="width: 20%;" class="table-n">Create By</th>
                    <th style="width: 20%;" class="table-n">Category</th>
                    <th style="width: 20%;" class="table-n">Reference</th>
                    <th style="width: 20%;" class="table-n">Customer</th>
                    <th style="width: 20%;" class="table-n">Supplier</th>
                    <th style="width: 20%;" class="table-n">Date Create</th>
                </tr>
            </thead>
            <tbody>
                <tr class="table-n">
                    <td class="table-n">{{ $inquiry->create_by }}</td>
                    <td class="table-n">{{ $inquiry->loc_imp }}</td>
                    <td class="table-n">{{ $inquiry->kode_inquiry }}</td>
                    <td class="table-n">{{ $inquiry->customer ? $inquiry->customer->name_customer : '-' }}</td>
                    <td class="table-n">{{ $inquiry->supplier ? $inquiry->supplier : '-' }}</td>
                    <td class="table-n">{{ $inquiry->created_at }}</td>
                </tr>
            </tbody>
        </table>

        <table>
            <thead>
                <tr>
                    <th style="width: 25px;">No</th>
                    <th style="width: 100px;">Raw Material</th>
                    <th style="width: 50px;">Shapes</th>
                    <th style="width: 40px;text-align:center;">Thickness</th>
                    <th style="width: 40px;text-align:center;">Width</th>
                    <th style="width: 40px; text-align:center;">Inner Dia</th>
                    <th style="width: 40px; text-align:center;">Outer Dia</th>
                    <th style="width: 50px;text-align:center;">Length</th>
                    <th style="width: 50px; text-align:center;">Qty
                        <p style="font-size: 9pt; text-align:center;">(in Pcs)</p>
                    </th>
                    <th style="width: 50px; text-align:center;">Forecast Month 1</th>
                    <th style="width: 50px; text-align:center;">Forecast Month 2</th>
                    <th style="width: 50px; text-align:center;">Forecast Month 3</th>
                    <th style="width: 70px; text-align:center;">Ship-to</th>
                    <th style="width: 50px; text-align:center;">Sales Order</th>
                    {{-- <th style="width: 50px; text-align:center;">PO Number</th> --}}
                    <th style="width: 50px;">Remark</th>
                </tr>
            </thead>
            <tbody id="table-body">
                @forelse ($materials as $index => $material)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $material->type_materials ? $material->type_materials->type_name : 'N/A' }}</td>
                        <td>{{ $material['jenis'] }}</td>
                        <td style="text-align:center;">{{ $material['thickness'] }}</td>
                        <td style="text-align:center;">{{ $material['weight'] }}</td>
                        <td style="text-align:center;">{{ $material['inner_diameter'] }}</td>
                        <td style="text-align:center;">{{ $material['outer_diameter'] }}</td>
                        <td style="text-align:center;">{{ $material['length'] }}</td>
                        <td style="text-align:center;">{{ $material['qty'] }}</td>
                        <td style="text-align:center;">{{ $material['m1'] }}</td>
                        <td style="text-align:center;">{{ $material['m2'] }}</td>
                        <td style="text-align:center;">{{ $material['m3'] }}</td>
                        <td style="text-align:center;">{{ $material['ship'] }}</td>
                        <td>{{ $material['so'] }}</td>
                        {{-- <td>{{ $material['nopo'] }}</td> --}}
                        <td>{{ $material['note'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="16" style="text-align: center;">Data tidak ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h4>Signature Details :</h4>
        <table class="table-n1">
            <thead class="table-n1">
                <tr class="table-n1">
                    <th style="width: 20%;" class="table-n1">Submitted</th>
                    <th style="width: 20%;" class="table-n1">Ka. Sie</th>
                    <th style="width: 20%;" class="table-n1">Ka. Dept</th>
                    <th style="width: 20%;" class="table-n1">Inventory</th>
                    <th style="width: 20%;" class="table-n1">Purchasing</th>
                </tr>
            </thead>
            <tbody>
                {{-- <td class="table-n1">{{ $inquiry->create_by }}</td> --}}
                <tr class="table-n1">
                    <td class="table-n1">
                        <p style="color: crimson;">Proposed</p>

                        <p style="font-size: 8pt;">{{ $signatures['submitted'] }}</p>
                        <small>Date : {{ \Carbon\Carbon::parse($inquiry->created_at)->format('d/m/Y H:i') }}</small>
                    </td>
                    <td class="table-n1">
                        <p style="color: crimson;">Approved</p>

                        <p style="font-size: 8pt;">{{ $signatures['approved_kasie'] }}</p>
                        <small>
                            Date : {{ \Carbon\Carbon::parse($inquiry->approved_kasie_at)->format('d/m/Y H:i') }}
                        </small>
                    </td>
                    <td class="table-n1">
                        <p style="color: crimson;">Approved</p>

                        <p style="font-size: 8pt;">{{ $signatures['approved_kadept'] }}</p>
                        <small>
                            Date : {{ \Carbon\Carbon::parse($inquiry->approved_kadept_at)->format('d/m/Y H:i') }}
                        </small>
                    </td>
                    <td class="table-n1">
                        <p style="color: crimson;">Approved</p>

                        <p style="font-size: 8pt;">{{ $signatures['approved_inventory'] }}</p>
                        <small>
                            Date : {{ \Carbon\Carbon::parse($inquiry->approved_inventory_at)->format('d/m/Y H:i') }}
                        </small>
                    </td>
                    <td class="table-n1">
                        <p style="color: crimson;">Confirmed</p>

                        <p style="font-size: 8pt;">{{ $signatures['confirmed_purchasing'] }}</p>
                        <small>
                            Date : {{ \Carbon\Carbon::parse($inquiry->confirmed_purchasing_at)->format('d/m/Y H:i') }}
                        </small>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
