
  <input type="hidden" name="id" value="{{ $upi->employee_id  ?? '' }}">
    <div class="mb-3">
        <label>UPI ID</label>
        <input type="text" name="upi_id"
               class="form-control"
               placeholder="example@upi"
               value="{{ $upi->upi_id ?? '' }}">
    </div>

    <div class="mb-3">
        <label>UPI App</label>
        <input type="text" name="upi_app"
               class="form-control"
               placeholder="GPay / PhonePe / Paytm"
               value="{{ $upi->upi_app ?? '' }}">
    </div>



