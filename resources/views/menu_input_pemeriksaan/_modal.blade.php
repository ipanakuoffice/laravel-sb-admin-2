<div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="dataForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add/Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama Pasien</label>
                        <select name="name" id="name" class="form-control" required>
                            <option value="">Pilih Pasien</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="modalitas">Modalitas</label>
                        <select name="modalitas" id="modalitas" class="form-control" required>
                            <option value="">Pilih Modalitas</option>
                            @foreach($modalities as $modalitas)
                                <option value="{{ $modalitas->id }}">{{ $modalitas->modalitas_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="indikator_dosis">Indikator Dosis</label>
                        <select name="indikator_dosis" id="indikator_dosis" class="form-control" required>
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
                    <button type="submit" id="saveBtn" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>