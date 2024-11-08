<!-- Modal Detail Modalitas -->
<div class="modal fade" id="detaiExaminationHistory" tabindex="-1" aria-labelledby="detailModalitasTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalitasTitle">Detail Modalitas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Loop untuk setiap dose indicator -->
                {{-- @foreach ($modalities as $modalitas)
                    <h5>Modalitas: {{ $modalitas->name }}</h5> --}}
                    
                    <h5>Modalitas: Obat </h5>
                    
                    {{-- @foreach ($modalitas->doseIndicators as $indicator) --}}
                        <div class="mb-4">
                            {{-- <h6>- Dose Indicator: {{ $indicator->name }}</h6> --}}
                            <h6>- Dose Indicator: Dosis indikator</h6>
                            <ul>
                                <!-- Loop untuk setiap pemeriksaan -->
                                {{-- @foreach ($indicator->examinations as $examination)
                                    <li>Pemeriksaan {{ $examination->id }}</li>
                                @endforeach --}}
                            </ul>
                            <!-- Tombol Unduh -->
                            <form  method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm mt-2">Download</button>
                            </form>
                        </div>
                    {{-- @endforeach
                @endforeach --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
