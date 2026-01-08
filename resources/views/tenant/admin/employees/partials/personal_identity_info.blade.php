<div class="card mb-4">
    <div class="card-header fw-bold">Personal & Identity Information</div>

    <div class="card-body">
        <div class="row g-3">



            <div class="col-md-4">
                <label class="form-label">Passport No</label>
                <input type="text" name="passport_no" class="form-control"
                       value="{{ old('passport_no', $employee->personalInfo->passport_no ?? '') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Passport Expiry</label>
                <input type="date" name="passport_expiry" class="form-control"
                       value="{{ old('passport_expiry', $employee->personalInfo->passport_expiry ?? '') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Identity No (Aadhar / PAN)</label>
                <input type="text" name="identity_no" class="form-control"
                       value="{{ old('identity_no', $employee->personalInfo->identity_no ?? '') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Nationality</label>
                <input type="text" name="nationality" class="form-control"
                       value="{{ old('nationality', $employee->personalInfo->nationality ?? '') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Religion</label>
                <input type="text" name="religion" class="form-control"
                       value="{{ old('religion', $employee->personalInfo->religion ?? '') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Marital Status</label>
                <select name="marital_status" class="form-select">
                    <option value="">Select</option>
                    <option value="Single" {{ ($employee->personalInfo->marital_status ?? '')=='Single'?'selected':'' }}>Single</option>
                    <option value="Married" {{ ($employee->personalInfo->marital_status ?? '')=='Married'?'selected':'' }}>Married</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Spouse Name</label>
                <input type="text" name="spouse_name" class="form-control"
                       value="{{ old('spouse_name', $employee->personalInfo->spouse_name ?? '') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Children</label>
                <input type="number" name="children" class="form-control" min="0"
                       value="{{ old('children', $employee->personalInfo->children ?? '') }}">
            </div>

        </div>
    </div>
</div>
