<div class="modal fade" id="addPatientModal" tabindex="-1" role="dialog" aria-labelledby="addPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> <!-- Modal lebar -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPatientModalLabel">Add New Patient</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addPatientForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6"> <!-- Kolom pertama -->
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="date_of_birth">Date of Birth</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                            </div>
                            <div class="form-group">
                                <label for="height">Height (cm)</label>
                                <input type="number" class="form-control" id="height" name="height" required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6"> <!-- Kolom kedua -->
                            <div class="form-group">
                                <label for="weight">Weight (kg)</label>
                                <input type="number" class="form-control" id="weight" name="weight" required>
                            </div>
                            <div class="form-group">
                                <label for="installation">Installation</label>
                                <input type="text" class="form-control" id="installation" name="installation" required>
                            </div>
                            <div class="form-group">
                                <label for="daily_dose">Daily Dose</label>
                                <input type="number" class="form-control" id="daily_dose" name="daily_dose" required>
                            </div>
                            <div class="form-group">
                                <label for="monthly_dose">Monthly Dose</label>
                                <input type="number" class="form-control" id="monthly_dose" name="monthly_dose" required>
                            </div>
                            <div class="form-group">
                                <label for="examination_type">Examination Type</label>
                                <input type="text" class="form-control" id="examination_type" name="examination_type" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="submitPatientForm" class="btn btn-primary">Save Patient</button>
                </div>
            </form>
        </div>
    </div>
</div>
