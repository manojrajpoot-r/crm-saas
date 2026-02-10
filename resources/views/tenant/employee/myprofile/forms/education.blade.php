<input type="hidden" name="id" value="{{ $education->employee_id  ?? '' }}">

    <div class="mb-3">
        <label>Institute</label>
        <input type="text" name="institute"
               class="form-control"
               value="{{ $education->institute ?? '' }}">
    </div>

    <div class="mb-3">
        <label>Degree</label>
        <input type="text" name="degree"
               class="form-control"
               value="{{ $education->degree ?? '' }}">
    </div>

    <div class="mb-3">
        <label>Stream</label>
        <input type="text" name="stream"
               class="form-control"
               value="{{ $education->stream ?? '' }}">
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label>From Date</label>
            <input type="date" name="from_date"
                   class="form-control"
                   value="{{ $education->from_date ?? '' }}">
        </div>

        <div class="col-md-6 mb-3">
            <label>To Date</label>
            <input type="date" name="to_date"
                   class="form-control"
                   value="{{ $education->to_date ?? '' }}">
        </div>
    </div>


