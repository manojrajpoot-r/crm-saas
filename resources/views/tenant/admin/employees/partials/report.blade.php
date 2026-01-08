<div class="card mb-4">
  <div class="card-header fw-bold">Report</div>
  <div class="card-body">
    <div class="row g-3">
      <div class="col-md-6">
        <label>Company Name</label>
        <input type="text" name="company_name" value="{{ old('company_name', $employee?->experience?->company_name) }}" class="form-control">
      </div>
      <div class="col-md-6">
        <label>Designation</label>
        <input type="text" name="experience_designation" value="{{ old('experience_designation', $employee?->experience?->designation) }}" class="form-control">
      </div>
      <div class="col-md-6">
        <label>From Date</label>
        <input type="date" name="from_date" value="{{ old('from_date', $employee?->experience?->from_date) }}" class="form-control">
      </div>
      <div class="col-md-6">
        <label>To Date</label>
        <input type="date" name="to_date" value="{{ old('to_date', $employee?->experience?->to_date) }}" class="form-control">
      </div>
    </div>
  </div>
</div>
</div>
