<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Address Information</h5>

        <button class="btn btn-sm btn-light openProfileModal"
                data-type="address">
            <i class="la la-pencil"></i>
        </button>
    </div>

    <div class="card-body" id="tableBody">
        <p><strong>Present Address:</strong> {{ ucwords($address->present_address) ?? '-' }}</p>
        <p><strong>Present Landmark:</strong> {{ ucwords($address->present_landmark) ?? '-' }}</p>
        <p><strong>Present Zipcode:</strong> {{ ucwords($address->present_zipcode) ?? '-' }}</p>
        <p><strong>Present Country:</strong> {{ ucwords($address->present_country) ?? '-' }}</p>
        <p><strong>Present State:</strong> {{ ucwords($address->present_state) ?? '-' }}</p>
        <p><strong>Present City:</strong> {{ ucwords($address->present_city) ?? '-' }}</p>

        <p><strong>Permanent Address:</strong> {{ ucwords($address->permanent_address) ?? '-' }}</p>
        <p><strong>Permanent Landmark:</strong> {{ ucwords($address->permanent_landmark) ?? '-' }}</p>
        <p><strong>Permanent Zipcode:</strong> {{ ucwords($address->permanent_zipcode) ?? '-' }}</p>
        <p><strong>Permanent Country:</strong> {{ ucwords($address->permanent_country)  ?? '-' }}</p>
        <p><strong>Permanent State:</strong> {{ ucwords($address->permanent_state) ?? '-' }}</p>
        <p><strong>Permanent City:</strong> {{ ucwords($address->permanent_city) ?? '-' }}</p>

    </div>
</div>
