<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">PersonalInfo Information</h5>

        <button class="btn btn-sm btn-light openProfileModal"
                data-type="personalInfo">
            <i class="la la-pencil"></i>
        </button>
    </div>

    <div class="card-body" id="tableBody">
        <p><strong>Passport Number:</strong> {{ $personalInfo->passport_no ?? '-' }}</p>
        <p><strong>Passport Expiry:</strong> {{ format_date($personalInfo->passport_expiry) ?? '-' }}</p>
        <p><strong>Identity Number:</strong> {{ $personalInfo->identity_no ?? '-' }}</p>

        <p><strong>Nationality:</strong> {{ ucwords($personalInfo->nationality) ?? '-' }}</p>
        <p><strong>Religion:</strong> {{ ucwords($personalInfo->religion) ?? '-' }}</p>
        <p><strong>Marital Status:</strong> {{ $personalInfo->marital_status ?? '-' }}</p>

        <p><strong>Spouse Name:</strong> {{ ucwords($personalInfo->spouse_name) ?? '-' }}</p>
        <p><strong>Children:</strong> {{ $personalInfo->children ?? '-' }}</p>

    </div>
</div>
