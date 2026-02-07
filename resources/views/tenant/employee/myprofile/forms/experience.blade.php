<input type="hidden" name="id" value="{{ $experience->employee_id  ?? '' }}">
    <div class="mb-3">
        <label>Company Name</label>
        <input type="text" name="company_name"
               class="form-control"
               value="{{ $experience->company_name ?? '' }}">
    </div>

    <div class="mb-3">
        <label>Designation</label>
        <input type="text" name="designation"
               class="form-control"
               value="{{ $experience->designation ?? '' }}">
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label>From Date</label>
            <input type="date" name="from_date"
                   class="form-control"
                   value="{{ $experience->from_date ?? '' }}">
        </div>

        <div class="col-md-6 mb-3">
            <label>To Date</label>
            <input type="date" name="to_date"
                   class="form-control"
                   value="{{ $experience->to_date ?? '' }}">
        </div>
    </div>
