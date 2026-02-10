<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Experience</h5>

        <button class="btn btn-sm btn-light openProfileModal"
                data-type="experience">
            <i class="la la-pencil"></i>
        </button>
    </div>

    <div class="card-body" id="tableBody">
        <p><strong>Company:</strong> {{ ucwords($experience->company_name) ?? '-' }}</p>
        <p><strong>Designation:</strong> {{ ucwords($experience->designation) ?? '-' }}</p>
        <p><strong>From:</strong> {{ format_date($experience->from_date) ?? '-' }}</p>
        <p><strong>To:</strong> {{ format_date($experience->to_date) ?? '-' }}</p>
    </div>
</div>
