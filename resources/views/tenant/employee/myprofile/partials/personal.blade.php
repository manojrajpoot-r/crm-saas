<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Personal Information</h5>

        <button class="btn btn-sm btn-light openProfileModal"
                data-type="personal">
            <i class="la la-pencil"></i>
        </button>
    </div>

    <div class="card-body" id="tableBody">
        <p><strong>Phone:</strong> {{ $employee->phone ?? '-' }}</p>
         <p><strong>Emergency Phone:</strong> {{ $employee->emergency_phone ?? '-'  }}</p>
        <p><strong>Email:</strong> {{ $employee->personal_email ?? '-' }}</p>
        <p><strong>Birthday:</strong> {{ format_date($employee->dob)?? '-' }}</p>
        <p><strong>Gender:</strong> {{ ucfirst($employee->gender) ?? '-' }}</p>
         <p><strong>Reports To:</strong> {{ ucfirst($employee->manager->first_name ?? '-') }} {{ ucfirst($employee->manager->first_name ?? '-') }} ( {{ ucfirst($employee->designation->name ?? '-') }})</p>
    </div>
</div>
