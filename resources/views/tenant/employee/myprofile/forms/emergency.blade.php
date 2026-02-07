<input type="hidden" name="id" value="{{ $emergency->employee_id  ?? '' }}">

    <div class="modal-body">

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Name</label>
                <input type="text" name="name"
                       class="form-control"
                       value="{{ $emergency->name ?? '' }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Relationship</label>
                <input type="text" name="relation"
                       class="form-control"
                       value="{{ $emergency->relation ?? '' }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Phone</label>
                <input type="text" name="phone"
                       class="form-control"
                       value="{{ $emergency->phone ?? '' }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Address</label>
                <textarea  name="address" rows="4"
                       class="form-control"
                       value="">{!! $emergency->address ?? '' !!}</textarea>
            </div>
        </div>

    </div>


