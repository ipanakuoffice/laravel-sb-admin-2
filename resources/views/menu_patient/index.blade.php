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
        <h1 class="h3 mb-0 text-gray-800">Patient</h1>
        <button class="btn btn-primary" id="addPatientBtn">Add New Patient</button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List Patient</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="list-patient-table" class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date of Birth</th>
                            <th>Gender</th>
                            <th>Height (cm)</th>
                            <th>Weight (kg)</th>
                            <th>Installation</th>
                            <th>Daily Dose</th>
                            <th>Monthly Dose</th>
                            <th>Examination Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('menu_patient.modalAdd')

@endsection

@section('script')
<script>
    $(document).ready(function() {

        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy'
        });

        $('#addPatientBtn').on('click', function() {
            $('#addPatientModal').modal('show');
        });

        getDataPatient();
        addDataPatient();

    });

    function getDataPatient(){
        $.ajax({
            url: 'patients/getData',
            type: 'get',
            datatype : 'json',
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
            success: function(response){
                $.unblockUI();
                console.log(response);
                $('#list-patient-table').DataTable().clear().destroy();
                    let rows = '';
                    $.each(response, function(index, patient) {
                        rows += `
                            <tr>
                                <td>${patient.name}</td>
                                <td>${patient.date_of_birth}</td>
                                <td>${patient.gender}</td>
                                <td>${patient.height}</td>
                                <td>${patient.weight}</td>
                                <td>${patient.installation}</td>
                                <td>${patient.daily_dose}</td>
                                <td>${patient.monthly_dose}</td>
                                <td>${patient.examination_type}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" onclick="editPatient(${patient.id})">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="deletePatient(${patient.id})">Delete</button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#list-patient-table tbody').html(rows);
                    $('#list-patient-table').DataTable();  
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                },
                complete: function() {
                    console.log("harusnya ditutup");
                    $.unblockUI(); 
                }
        })
    }

    function addDataPatient(){
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $('#submitPatientForm').on('click', function() {
            event.preventDefault();
            console.log("icikiwir ini dijalankan");

            $.ajax({
                url: 'patients/addPatient',
                type: 'post',
                data: $('#addPatientForm').serialize(),
                beforeSend: function(){
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
                    getDataPatient();
                    $.unblockUI();
                    if (response.status === 'success') {
                        $('#addPatientModal').modal('hide');
                    }
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            alert(value[0]);
                        });
                    } else {
                        alert("Terjadi kesalahan. Silakan coba lagi.");
                    }
                },
                complete: function() {
                    $.unblockUI(); 
                }

            });
        });

    }

    function editPatient(patientId) {
        $.ajax({
            url : `patients/editPatient/${patientId}`,
            type : 'get',
            success : function(response) {
                $('#name').val(response.name);
                $('#date_of_birth').val(response.date_of_birth);
                $('#height').val(response.height);
                $('#weight').val(response.weight);
                $('#gender').val(response.gender);
                $('#installation').val(response.installation);
                $('#daily_dose').val(response.daily_dose);
                $('#monthly_dose').val(response.monthly_dose);
                $('#examination_type').val(response.examination_type);
                $('#submitPatientForm').text('Update Patient');
                $('#addPatientModal').modal('show');
                $('#submitPatientForm').off('click').on('click', function(event) {
                event.preventDefault();
                updatePatient(patientId);
            });
            },
            error: function(xhr) {
            console.error("Error fetching patient data:", xhr);
            alert('Error fetching patient data. Please try again.');}
        })
    }

    function updatePatient(patientId){
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        console.log($('#addPatientForm').serialize());

        $.ajax({
            url : `patients/updatePatient/${patientId}`,
            type : 'put',
            data : $('#addPatientForm').serialize(),
            beforeSend: function() {
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
            success: function(response){
                $('#addPatientModal').modal('hide');
                getDataPatient();
            },
            error: function(xhr){
                const errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                alert(value[0]);
                });
            },
            complete: function() {
                $.unblockUI(); 
            }
        })
    }
    function deletePatient(patientId) {
        console.log("Delete patient ID:", patientId);

    }

    function deletePatient(patientId) {
    if (confirm("Apakah Anda yakin ingin menghapus pasien ini?")) {
        $.ajax({
            url: `patients/deletePatient/${patientId}`,
            type: 'DELETE', // Menggunakan metode DELETE
            success: function(response) {
                if (response.status === 'success') {
                    alert('Pasien berhasil dihapus.');
                    getDataPatient(); // Perbarui tabel
                } else {
                    alert('Terjadi kesalahan saat menghapus pasien.');
                }
            },
            error: function(xhr) {
                console.error("Error deleting patient:", xhr);
                alert("Terjadi kesalahan saat menghapus pasien. Silakan coba lagi.");
            }
        });
    }
}

</script>
@endsection
