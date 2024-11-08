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
        <h1 class="h3 mb-0 text-gray-800">Input Rencana Pemeriksaan</h1>
        <button class="btn btn-primary" id="addDataBtn"><i class="fa fa-plus mr-2"></i> Add New Data</button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List Plan Examination</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="input-pemeriksaan-table" class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th style="width: 200px;">Name</th>
                            <th>NIP</th>
                            <th>Modalitas</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('menu_input_pemeriksaan._modal') 
@endsection

@section('script')
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#input-pemeriksaan-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('input-pemeriksaan.index') }}", 
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'nip', name: 'nip' },
                { data: 'modalitas_name', name: 'modalitas_name' },
                { data: 'created', name: 'created' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        $('#addDataBtn').click(function() {
            $('#dataForm').trigger("reset");
            $('#dataModal').modal('show');
            $('#modalTitle').text("Add New Data");
            $('#saveBtn').data('action', 'add');
        });

        $('#saveBtn').click(function(e) {
            e.preventDefault();
            let action = $(this).data('action');
            let id = $('#dataId').val(); 
            
            let url = action === 'add'
                ? "{{ route('input-pemeriksaan.store') }}" 
                : "{{ route('input-pemeriksaan.update', ':id') }}".replace(':id', id);

            let type = action === 'add' ? "POST" : "PUT";

            $.ajax({
                url: url,
                type: type,
                data: $('#dataForm').serialize(),
                success: function(response) {
                    $('#dataModal').modal('hide');
                    table.ajax.reload();
                    alert(response.message);
                },
                error: function(response) {
                    if (response.responseJSON && response.responseJSON.errors) {
                        let errors = response.responseJSON.errors;
                        let errorMessage = '';
                        for (let field in errors) {
                            errorMessage += errors[field].join(', ') + '\n';
                        }
                        alert(errorMessage);
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                }
            });
        });


        $('body').on('click', '.editBtn', function() {
            let id = $(this).data('id');
            $.get("{{ route('input-pemeriksaan.index') }}/" + id + "/edit", function(data) {
                $('#dataModal').modal('show');
                $('#modalTitle').text("Edit Data");
               
                $('#dataId').val(data.id);
                $('#patient_id').val(data.patient_id);  
                $('#modalitas_id').val(data.modalitas_id);  
                $('#dose_indicator_id').val(data.dose_indicator_id);
                $('#tegangan').val(data.tegangan);  
                $('#dosis').val(data.dosis); 
                $('#result').val(data.result);  
                $('#note').val(data.note);  
                
                $('#saveBtn').data('action', 'update');
            });
        });

        $('body').on('click', '.deleteBtn', function() {
            let id = $(this).data('id');
            if (confirm("Are you sure you want to delete this data?")) {
                $.ajax({
                    url: "{{ route('input-pemeriksaan.destroy', '') }}/" + id,
                    type: "DELETE",
                    success: function(response) {
                        table.ajax.reload();
                        alert(response.message);
                    },
                    error: function(response) {
                        console.error("Error:", response);
                        alert('An error occurred. Please try again.');
                    }
                });
            }
        });
    });
</script>
@endsection