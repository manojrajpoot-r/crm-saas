<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Education</h5>

        <button class="btn btn-sm btn-light openProfileModal"
                data-type="education">
            <i class="la la-pencil"></i>
        </button>
    </div>

    <div class="card-body" id="tableBody">
        <p><strong>Institute:</strong> {{ ucwords($education->institute) ?? '-' }}</p>
        <p><strong>Degree:</strong> {{ ucwords($education->degree) ?? '-' }}</p>
        <p><strong>Stream:</strong> {{ $education->stream ?? '-' }}</p>
        <p><strong>From:</strong> {{ format_date($education->from_date) ?? '-' }}</p>
        <p><strong>To:</strong> {{ format_date($education->to_date) ?? '-' }}</p>
    </div>
</div>
