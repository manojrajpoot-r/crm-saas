<input type="hidden" name="id" value="{{ $bank->employee_id  ?? '' }}">

    <div class="modal-body">

        <div class="mb-3">
            <label>Account Holder Name</label>
            <input type="text" name="account_name"
                   class="form-control"
                   value="{{ $bank->account_name ?? '' }}">
        </div>

        <div class="mb-3">
            <label>Account Number</label>
            <input type="text" name="account_no"
                   class="form-control"
                   value="{{ $bank->account_no ?? '' }}">
        </div>

        <div class="mb-3">
            <label>Bank Name</label>
            <input type="text" name="bank_name"
                   class="form-control"
                   value="{{ $bank->bank_name ?? '' }}">
        </div>

        <div class="mb-3">
            <label>IFSC Code</label>
            <input type="text" name="ifsc"
                   class="form-control"
                   value="{{ $bank->ifsc ?? '' }}">
        </div>

             <div class="mb-3">
            <label>Pan Number</label>
            <input type="text" name="pan_no"
                   class="form-control"
                   value="{{ $bank->pan_no ?? '' }}">
        </div>

        <div class="mb-3">
            <label>Aadhaar Number</label>
            <input type="text" name="uan_no"
                   class="form-control"
                   value="{{ $bank->uan_no ?? '' }}">
        </div>


    </div>

