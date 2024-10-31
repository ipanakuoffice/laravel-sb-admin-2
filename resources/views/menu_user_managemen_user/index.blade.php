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

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List User</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="list-user-table" class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <th> Nama </th>
                        <th> Role </th>
                    </thead>
                    <tbody>
                    </tbody>
                <table>
            </div>
        </div>
    </div>

@endsection
@section('script')
<script>
    $(document).ready(function(){
        function getAllUser() {
            $.ajax({
                url: 'user/getData', 
                type: 'GET',
                dataType: 'json',
                beforeSend: function(){
                    console.log("icikiwir");
                        $.blockUI({
                        message: '<i class="icon-spinner4 spinner"></i>',
                        overlayCSS: {
                        backgroundColor: '#fff',
                        opacity: 0.8,
                        cursor: 'wait'
                        },
                        css: {
                            border: 0,
                            padding: 0,
                            backgroundColor: 'transparent'
                        }
                    });
                },
                success: function(response) {
                    $('#list-user-table').DataTable().clear().destroy();
                    console.log(response);
                    console.log("Response Data:", response.users);

                    $.unblockUI();
                    let rows = '';
                    $.each(response, function(index, user) {
                        rows += `
                            <tr>
                                <td>${user.name}</td>
                                <td>${user.role_name}</td>
                            </tr>
                        `;
                    });
                    $('#list-user-table tbody').html(rows);
                    $('#list-user-table').DataTable();  
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });
        }

        // Memanggil fungsi getUserData untuk menampilkan data saat halaman dimuat
        getAllUser();
    });
</script>
@endsection
