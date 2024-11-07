<!-- Modal Add/Edit -->
<div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">    <div class="modal-dialog">
        <div class="modal-content">
            <form id="dataForm">
                <!-- CSRF Token -->
                <meta name="csrf-token" content="{{ csrf_token() }}">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add/Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="patient_id">Nama Pasien</label>
                        <select name="patient_id" id="patient_id" class="form-control" required>
                            <option value="">Pilih Pasien</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="modalitas_id">Modalitas</label>
                        <select name="modalitas_id" id="modalitas_id" class="form-control" required>
                            <option value="">Pilih Modalitas</option>
                            @foreach($modalities as $modalitas)
                                <option value="{{ $modalitas->id }}">{{ $modalitas->modalitas_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="dose_indicator_id">Indikator Dosis</label>
                        <select name="dose_indicator_id" id="dose_indicator_id" class="form-control" required>
                            <option value="">Pilih Indikator Dosis</option>
                            @foreach($doseIndicators as $indikator)
                                <option value="{{ $indikator->id }}">{{ $indikator->dose_indicator_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tegangan">Tegangan (V)</label>
                        <input type="number" name="tegangan" id="tegangan" class="form-control" placeholder="Masukkan tegangan" required>
                    </div>

                    <div class="form-group">
                        <label for="dosis">Dosis (mGy)</label>
                        <input type="number" name="dosis" id="dosis" class="form-control" placeholder="Masukkan dosis" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" id="saveBtn" class="btn btn-primary" data-action="add">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>