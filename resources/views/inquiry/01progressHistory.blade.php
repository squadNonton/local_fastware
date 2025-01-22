@extends('layout')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>History Progress</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('createinquiry') }}">Menu Inquiry Sales</a></li>
                    <li class="breadcrumb-item active">History Progress</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Inquiry Reference: {{ $inquiry->kode_inquiry }}</h5>

                    <div class="table-responsive">
                        <table class="table table-1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Progress Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($progressUpdates as $index => $progress)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $progress->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ $progress->user->name }}</td> <!-- Pastikan relasi user ada -->
                                        <td>{{ $progress->description }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
