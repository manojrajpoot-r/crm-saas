<div class="card">
    <div class="card-header fw-bold">Bank & UPI Information</div>

    <div class="card-body">
        <div class="row g-3">

            <div class="col-md-6">
                <label>Account Name</label>
                <input type="text" name="account_name" value="{{ old('account_name', $employee?->bankInfo?->account_name) }}" class="form-control">
            </div>

            <div class="col-md-6">
                <label>Bank Name</label>
                <input type="text" name="bank_name" value="{{ old('bank_name', $employee?->bankInfo?->bank_name) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Account Number</label>
                <input type="text" name="account_no" data-validate="account" value="{{ old('account_no', $employee?->bankInfo?->account_no) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label>IFSC Code</label>
                <input type="text" name="ifsc"  data-validate="ifsc" value="{{ old('ifsc', $employee?->bankInfo?->ifsc) }}" class="form-control">
            </div>


            <div class="col-md-6">
                <label>PAN ID</label>
                <input type="text" name="pan_no" data-validate="pan" value="{{ old('pan_no', $employee?->bankInfo?->pan_no) }}" class="form-control">
            </div>

            <div class="col-md-6">
                <label>Aadhar ID</label>
                <input type="text" name="uan_no" data-validate="aadhaar" value="{{ old('uan_no', $employee?->bankInfo?->uan_no) }}" class="form-control">
            </div>
            <div class="card-header fw-bold">Bank & UPI Information</div>

            <div class="col-md-6">
                <label>UPI ID</label>
                <input type="text" name="upi_id" data-validate="upi" value="{{ old('upi_id', $employee?->upiInfo?->upi_id) }}" class="form-control">
            </div>

              <div class="col-md-6">
                <label>UPI App</label>
                <input type="text" name="upi_app"
                       value="{{ old('upi_app', $employee?->upiInfo?->upi_app) }}"
                       class="form-control">
            </div>


        </div>
    </div>
</div>
