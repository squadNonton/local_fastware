@extends('layout')

@section('content')

    <style>
        body {
            font-family: 'Cambria', serif;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .fotext {
            font-family: 'Cambria', serif;
            font-size: 10pt;
            font-weight: bold;
        }

        table th {
            background-color: #f2f2f2;
        }

        .form-section {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .form-section .form-group {
            flex: 1 1 15%;
            /* Adjust this value to control the width of each item */
            margin-right: 2px;
            margin-bottom: 15px;
        }

        .form-section label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        .add-column-button {
            margin-top: 15px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .swal2-popup {
            width: 300px;
            /* Mengatur lebar pop-up */
            font-size: 0.7rem;
            /* Mengatur ukuran font */
        }

        .swal2-title {
            font-family: 'Cambria', serif;
        }
    </style>


    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Preview</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('createinquiry') }}">Menu Inquiry Sales</a></li>
                    <li class="breadcrumb-item active">Formulir Inquiry Sales</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="form-section mt-3">
                        <div class="form-group">
                            <label>Create By :</label>
                            <div class="form-value">{{ $inquiry->create_by }}</div>
                        </div>
                        <div class="form-group">
                            <label>Category :</label>
                            <div class="form-value">{{ $inquiry->loc_imp }}</div>
                        </div>
                        <div class="form-group">
                            <label>Reference :</label>
                            <div class="form-value">{{ $inquiry->kode_inquiry }}</div>
                        </div>
                        <div class="form-group">
                            <label>Customer :</label>
                            <div class="form-value">{{ $inquiry->customer ? $inquiry->customer->name_customer : 'N/A' }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Supplier :</label>
                            <div class="form-value">{{ $inquiry->supplier }}</div>
                        </div>
                        <div class="form-group">
                            <label>Date Create :</label>
                            <div class="form-value">{{ $inquiry->created_at }}</div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 25px;">No</th>
                                    <th style="width: 100px;">Raw Material</th>
                                    <th style="width: 50px;">Shapes</th>
                                    <th style="width: 40px;">Thickness</th>
                                    <th style="width: 40px;">Weight</th>
                                    <th style="width: 40px;">Inner Dia</th>
                                    <th style="width: 40px;">Outer Dia</th>
                                    <th style="width: 50px;">Lenght</th>
                                    <th style="width: 50px; text-align:center;">Qty
                                        <p style="font-size: 9pt; text-align:center;">(in Pcs)</p>
                                    </th>
                                    <th style="width: 50px; text-align:center;">Forecast Mounth 1</th>
                                    <th style="width: 50px; text-align:center;">Forecast Mounth 2</th>
                                    <th style="width: 50px; text-align:center;">Forecast Mounth 3</th>
                                    <th style="width: 90px; text-align:center;">Ship-to</th>
                                    <th style="width: 50px; text-align:center;">Sales Order</th>
                                    <th style="width: 50px;">Remark</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @forelse ($materials as $index => $material)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $material->type_materials ? $material->type_materials->type_name : 'N/A' }}
                                        </td>
                                        <!-- Menampilkan type_name -->
                                        <td>{{ $material['jenis'] }}</td>
                                        <td>{{ $material['thickness'] }}</td>
                                        <td>{{ $material['weight'] }}</td>
                                        <td>{{ $material['inner_diameter'] }}</td>
                                        <td>{{ $material['outer_diameter'] }}</td>
                                        <td>{{ $material['length'] }}</td>
                                        <td>{{ $material['qty'] }}</td>
                                        <td>{{ $material['m1'] }}</td>
                                        <td>{{ $material['m2'] }}</td>
                                        <td>{{ $material['m3'] }}</td>
                                        <td>{{ $material['ship'] }}</td>
                                        <td>{{ $material['so'] }}</td>
                                        <td>{{ $material['note'] }}</td>
                                        {{-- <td>{{ $material['file'] }}</td> --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="15" style="text-align: center;">Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($inquiry->status == 2)
                        @if ($isFromApproval)
                            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm m-1">Kembali</a>
                        @else
                            <a href="{{ route('formulirInquiry', $inquiry->id) }}"
                                class="btn btn-secondary add-row-button btn-sm m-1">Correction</a>
                            <a href="{{ route('createinquiry') }}"
                                class="btn btn-primary delete-row-button btn-sm m-1">Submit</a>
                        @endif
                    @endif
                    <a class="btn btn-secondary add-row-button btn-sm" onclick="goBack()">Kembali</a>
                    <a href="{{ route('showFormSS.pdf', $inquiry->id) }}" class="btn btn-danger btn-sm m-1">
                        <i class="bi bi-file-earmark-pdf"></i> Download PDF
                    </a>
                </div>

                {{-- Uploaded File --}}
                <div class="card p-2 m-4">
                    <div class="card-body">
                        <div class="form-group mb-4">
                            <button type="button" class="btn btn-primary btn-sm mb-2" style="background-color: orangered"
                                onclick="submitUploadForm()"><i class="ri-hail-fill fs-6"></i>
                            </button>

                            <label for="attachments" class="ms-2">Upload Attachments (PDF, PNG, JPG, JPEG)</label>
                            <input type="file" id="attachments" name="attachments[]" multiple
                                accept=".pdf,.png,.jpg,.jpeg" class="form-control">
                        </div>


                        <h5 class="fotext">Uploaded Files:</h5>
                        <ul id="uploaded-files-list">
                            @if (!empty($uploadedFiles))
                                @foreach ($uploadedFiles as $file)
                                    <li>
                                        <a href="{{ asset('assets/inquiry/' . $file) }}"
                                            target="_blank">{{ $file }}</a>
                                    </li>
                                @endforeach
                            @else
                                <li>No files uploaded.</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="container">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table>
                                    <h5 class="card-title text-center">Inquiry Reference: {{ $inquiry->kode_inquiry }}</h5>
                                    <thead>
                                        <tr>
                                            <th style="width : 60px">No</th>
                                            <th class="text-center" style="width : 300px">Date</th>
                                            <th class="text-center" style="width : 250px">User</th>
                                            <th class="text-center">Progress Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tbody>
                                        @foreach ($progressUpdates as $index => $progress)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $progress->created_at->format('d/m/Y H:i') }}</td>
                                                <td>{{ $progress->user ? $progress->user->name : 'Purchase has not been updated' }}
                                                </td>
                                                <td>{{ $progress->description }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <!-- excel -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
        <script>
            function goBack() {
                window.history.back();
            }
        </script>

        <script>
            function submitUploadForm() {
                var formData = new FormData();
                var attachments = document.getElementById('attachments').files;

                // Pastikan ada file yang diupload
                if (attachments.length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR..!!',
                        text: 'Please select the file to upload.',
                        iconHtml: '<i class="ri-emotion-sad-fill"></i>',
                        customClass: {
                            popup: 'my-popup'
                        }
                    });
                    return;
                }

                formData.append('id_inquiry', '{{ $inquiry->id }}');

                // Tambahkan file ke formData
                for (var i = 0; i < attachments.length; i++) {
                    formData.append('attachments[]', attachments[i]);
                }

                // Kirim data ke server menggunakan AJAX
                $.ajax({
                    url: '{{ route('uploadFile') }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Files uploaded successfully.',
                            iconHtml: '<i class="ri-emotion-laugh-fill"></i>', // Ganti dengan ikon kustom Anda
                            showCloseButton: true, // Menampilkan ikon tutup jika diinginkan
                            customClass: {
                                popup: 'my-popup-class' // Misalnya, kelas khusus untuk pop-up
                            }
                        }).then(() => {
                            // Tampilkan daftar file yang di-upload
                            showUploadedFiles(response.uploadedFiles);
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error!', 'An error occurred while uploading files.', 'error');
                    }
                });
            }

            // function showUploadedFiles(files) {
            //     var fileListContainer = document.getElementById('uploaded-files-list'); // Buat elemen ini di HTML

            //     fileListContainer.innerHTML = ''; // Kosongkan daftar sebelumnya
            //     files.forEach(function(file) {
            //         var li = document.createElement('li');
            //         li.textContent = file; // Nama file yang di-upload
            //         fileListContainer.appendChild(li); // Tambahkan ke dalam daftar
            //     });
            // }

            function showUploadedFiles(files) {
                var fileListContainer = document.getElementById('uploaded-files-list');

                // Hanya tambahkan file yang baru saja di-upload
                files.forEach(function(file) {
                    var li = document.createElement('li');
                    var link = document.createElement('a');
                    link.href = '{{ asset('assets/inquiry') }}/' + file; // Sesuaikan path
                    link.target = '_blank'; // Buka di tab baru
                    link.textContent = file; // Nama file
                    li.appendChild(link); // Tambahkan tautan ke elemen list
                    fileListContainer.appendChild(li); // Tambahkan ke daftar
                });
            }
        </script>
    </main><!-- End #main -->
@endsection
