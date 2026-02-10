<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">UPI Information</h5>

        <button class="btn btn-sm btn-light openProfileModal"
                data-type="upi">
            <i class="la la-pencil"></i>
        </button>
    </div>

    <div class="card-body" id="tableBody">
        <p><strong>UPI ID:</strong> {{ $upi->upi_id ?? '-' }}</p>
        <p><strong>UPI App:</strong> {{ $upi->upi_app ?? '-' }}</p>
    </div>
</div>
