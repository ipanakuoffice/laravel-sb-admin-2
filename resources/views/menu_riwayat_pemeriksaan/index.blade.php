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
    @include('menu_riwayat_pemeriksaan._modal')
    @include('menu_riwayat_pemeriksaan._modalChart')
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
                data: null,
                render: function(data, type, row) {
                    return '<button class="btn btn-primary btn-print" id="showDetailHistory" data-id="'+ row.id +'" data-patient-id="'+ row.patientId +'" data-m-id="'+ row.modalitasId +'">Detail</button>';
                },
                orderable: false, 
                searchable: false 
                }
            ]
        });
        

        $('body').on('click', '#showDetailHistory', function() {
            const patientId = $(this).data('patient-id');
            const modalitasId = $(this).data('m-id');

            $.get("{{ url('riwayat-pemeriksaan/riwayat-pemeriksaan') }}/" + patientId + "?modalitas_id=" + modalitasId, function(data) {
                let content = '';
                $('#detaiExaminationHistory').modal('show');
                $('#modalTitle').text("Detail Data");

              
                 // Group by dose indicator
                const groupedByDoseIndicator = data.reduce((acc, modality) => {
                    if (!acc[modality.dose_indicator_name]) {
                        acc[modality.dose_indicator_name] = [];
                    }
                    acc[modality.dose_indicator_name].push(modality);
                    return acc;
                }, {});

                console.log(data);
                content += `
                    <div class="card-header bg-light d-flex justify-content-between align-items-center border-bottom mb-3" style="padding: 15px; border-radius: 5px;">
                        <div>
                            <h5 class="mb-2">Nama Pasien: <span class="font-weight-normal">${data[0].name}</span></h5>
                            <h5 class="mb-2">Berat Badan: <span class="font-weight-normal">${data[0].weight} kg</span></h5>
                        </div>
                        <div>
                            <h5 class="mb-2">Tinggi Badan: <span class="font-weight-normal">${data[0].height} cm</span></h5>
                            <h5 class="mb-2">NIP: <span class="font-weight-normal">${data[0].nip}</span></h5>
                        </div>
                    </div>
                `;


                for (const [doseIndicator, modalities] of Object.entries(groupedByDoseIndicator)) {
                    content += `
                        <div class="pb-3" style="border: 1px solid blue; padding: 15px; border-radius: 5px; margin-bottom: 15px;">
                            <div class="d-flex flex-row justify-content-between">
                                <div>
                                    <h5>Modalitas: ${modalities[0].modalitas_name}</h5> 
                                    <h6>- Dose Indicator: ${doseIndicator}</h6>
                                </div>
                                <div>
                                    <form method="POST" }}/${doseIndicator}" class="mb-3">
                                        @csrf
                                        <button type="button" id="showChartBtn" class="btn btn-primary btn-sm">Lihat Grafik</button>
                                    </form>
                                </div>
                            </div>

                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Dosis</th>
                                        <th>Tegangan</th>
                                        <th>Hasil</th>
                                        <th>Catatan</th>
                                        <th>Tanggal Pemeeriksaan </th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;

                    let index = 1;
                    modalities.forEach(function(modality) {
                        content += `
                            <tr>
                                <td>${index++}</td>
                                <td>${modality.dosis}</td>
                                <td>${modality.tegangan}</td>
                                <td>${modality.result || 'N/A'}</td>
                                <td>${modality.note || 'N/A'}</td>
                                <td>${modality.created_at || 'N/A'} </td>
                            </tr>
                        `;
                    });

                    content += `
                                </tbody>
                            </table>
                        </div>
                    `;
                }

                $('#modalContent').html(content);
                $('body').on('click', '#showChartBtn', function () {
                    $('#chartModal').modal('show');
                    const patientId = data[0].patient_id;
                    const modalitasId = data[0].modalitas_id;
                    const doseIndicatorId = data[0].dose_indicator_id;

                    $.get("{{ route('riwayat-pemeriksaan.chart') }}?patientId=" + patientId + "&modalitasId=" + modalitasId + "&doseIndicatorId=" + doseIndicatorId, function (chartData) {
                        const doses = chartData.map(item => item.dosis);
                        const tegangans = chartData.map(item => item.tegangan);

                        if (window.chart) {
                            window.chart.destroy();
                        }

                        const ctx = document.getElementById('doseChart').getContext('2d');
                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: doses,
                                datasets: [{
                                    label: 'Tegangan',
                                    data: tegangans,
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    });
                });

            });
        });


    });
</script>

@endsection