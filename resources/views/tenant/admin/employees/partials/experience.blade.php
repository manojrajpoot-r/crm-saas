<div class="card">
    <div class="card-header fw-bold">Experience Information</div>

    <div class="card-body">
        <div class="row g-3">

            <div class="col-md-6">
                <label>Company Name</label>
                <input type="text" name="company_name"
                       value="{{ old('company_name', $employee?->experiences?->first()?->company_name) }}"
                       class="form-control">
            </div>

            <div class="col-md-6">
                <label>Designation</label>
                <input type="text" name="designation"
                       value="{{ old('designation', $employee?->experiences->first()?->designation) }}"
                       class="form-control">
            </div>

            <div class="col-md-6">
                <label>From Date</label>
                <input type="date" name="from_date"
                       value="{{ old('from_date', $employee?->experiences->first()?->from_date) }}"
                       class="form-control">
            </div>

            <div class="col-md-6">
                <label>To Date</label>
                <input type="date" name="to_date"
                       value="{{ old('to_date', $employee?->experiences->first()?->to_date) }}"
                       class="form-control">
            </div>

        </div>
    </div>
</div>

