<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Emergency Contact</h5>

        <button class="btn btn-sm btn-light openProfileModal"
                data-type="emergency">
            <i class="la la-pencil"></i>
        </button>
    </div>

    <div class="card-body" id="tableBody">
        <p><strong>Name:</strong> {{ ucwords($emergency->name) ?? '-' }}</p>
        <p><strong>Relation:</strong> {{ ucwords($emergency->relation) ?? '-' }}</p>
        <p><strong>Phone:</strong> {{ $emergency->phone ?? '-' }}</p>
        <p><strong>Address:</strong> {{ ucwords($emergency->address) ?? '-' }}</p>
    </div>
</div>
