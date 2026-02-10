<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Bank Details</h5>

        <button class="btn btn-sm btn-light openProfileModal"
                data-type="bank">
            <i class="la la-pencil"></i>
        </button>
    </div>

    <div class="card-body" id="tableBody">
        <p><strong>Bank Name:</strong> {{ ucwords($bank->bank_name) ?? '-' }}</p>
        <p><strong>Account No:</strong> {{ $bank->account_no ?? '-' }}</p>
        <p><strong>IFSC Code:</strong> {{ $bank->ifsc ?? '-' }}</p>
        <p><strong>Account Holder:</strong> {{ ucwords($bank->account_name) ?? '-' }}</p>
        <p><strong>Pan Number:</strong> {{ $bank->pan_no ?? '-' }}</p>
        <p><strong>Aadhaar Number:</strong> {{ $bank->uan_no ?? '-' }}</p>
    </div>
</div>
