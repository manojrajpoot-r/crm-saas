<div class="card">
    <div class="card-header fw-bold">Education Information</div>

    <div class="card-body">
        <div class="row g-3">

            <div class="col-md-6">
                <label>Degree</label>
                <input type="text" name="degree"
                       value="{{ old('degree', $employee?->educations->first()?->degree) }}"
                       class="form-control">
            </div>

            <div class="col-md-6">
                <label>Institute</label>
                <input type="text" name="institute"
                       value="{{ old('institute', $employee?->educations->first()?->institute) }}"
                       class="form-control">
            </div>

            <div class="col-md-6">
                <label>Stream</label>
                <input type="text" name="stream"
                       value="{{ old('stream', $employee?->educations->first()?->stream) }}"
                       class="form-control">
            </div>

            <div class="col-md-6">
                <label>From Date</label>
                <input type="date" name="from_date"
                       value="{{ old('from_date', $employee?->educations->first()?->from_date) }}"
                       class="form-control">
            </div>
                 <div class="col-md-6">
                <label>To Date</label>
                <input type="date" name="to_date"
                       value="{{ old('to_date', $employee?->educations->first()?->to_date) }}"
                       class="form-control">
            </div>

        </div>
    </div>
</div>
