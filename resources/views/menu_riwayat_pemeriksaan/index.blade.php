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
                        <th>Modalitas</th>
                        <th>Total Pemeriksaan</th>
                        <th>Tanggal Periksa Terakhir</th>
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

@endsection