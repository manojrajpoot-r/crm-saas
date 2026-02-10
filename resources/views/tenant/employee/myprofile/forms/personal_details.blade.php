<input type="hidden" name="id" value="{{ $personalInfo->employee_id  ?? '' }}">
    <div class="mb-3">
        <label>Passport Number</label>
        <input type="text" name="passport_no"
               class="form-control"
               value="{{ $personalInfo->passport_no ?? '' }}">
    </div>

    <div class="mb-3">
        <label>Passport Expiry</label>
        <input type="text" name="passport_expiry"
               class="form-control"
               value="{{ $personalInfo->passport_expiry ?? '' }}">
    </div>

    <div class="mb-3">
        <label>Identity Number</label>
        <input type="text" name="identity_no"
               class="form-control"
               value="{{ $personalInfo->identity_no ?? '' }}">
    </div>

    <div class="mb-3">
        <label>Nationality</label>
        <input type="text" name="nationality"
               class="form-control"
               value="{{ $personalInfo->nationality ?? '' }}">
    </div>

        <div class="mb-3">
            <label>Religion</label>
            <input type="text" name="religion"
                class="form-control"
                value="{{ $personalInfo->religion ?? '' }}">
        </div>

        <div class="mb-3">
            <label>Marital Status</label>
            <input type="text" name="marital_status"
                class="form-control"
                value="{{ $personalInfo->marital_status ?? '' }}">
        </div>

        <div class="mb-3">
            <label>Spouse Name</label>
            <input type="text" name="spouse_name"
                class="form-control"
                value="{{ $personalInfo->spouse_name ?? '' }}">
        </div>

        <div class="mb-3">
            <label>Children</label>
            <input type="text" name="children"
                class="form-control"
                value="{{ $personalInfo->children ?? '' }}">
    </div>

