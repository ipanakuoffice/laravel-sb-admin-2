@extends('layouts.admin')

@section('main-content')
    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Riwayat Pemeriksaan</h1>
        <button class="btn btn-primary" id="downloadBtn"><i class="fa fa-download mr-2"></i> Download</button>

    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List Pemeriksaan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="riwayat-pemeriksaan-table" class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th style="width: 200px;">Name</th>
                        <th> NIP </th>
                        <th>Modalitas</th>
                        <th>Total Pemeriksaan</th>
                        <th>Tanggal Periksa Terakhir</th>
                        <th>Total Pemeriksaan </th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        var examinationHistory = @json($examinationHistory); // Mengonversi koleksi ke array JSON
        $('#riwayat-pemeriksaan-table').DataTable({
            data: examinationHistory,
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'nip', name: 'nip' },
                { data: 'modalitas_name', name: 'modalitas_name' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'total_pemeriksaan', name: 'total_pemeriksaan' },
                {
                data: null, // Kolom untuk tombol aksi
                render: function(data, type, row) {
                    return '<button class="btn btn-primary btn-print" data-id="'+ row.id +'">Print</button>';
                },
                orderable: false,  // Menonaktifkan pengurutan pada kolom aksi
                searchable: false  // Menonaktifkan pencarian pada kolom aksi
                }
            ]
        });
    });
</script>

@endsection