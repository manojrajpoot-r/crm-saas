<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Family Information</h5>

        <button class="btn btn-sm btn-light openProfileModal"
                data-type="family">
            <i class="la la-pencil"></i>
        </button>
    </div>

    <div class="card-body" id="tableBody">
        <p><strong>Name:</strong> {{ ucwords($family->name) ?? '-' }}</p>
        <p><strong>Relation:</strong> {{ ucwords($family->relation) ?? '-' }}</p>
        <p><strong>Phone:</strong> {{ $family->phone ?? '-' }}</p>
    </div>
</div>
