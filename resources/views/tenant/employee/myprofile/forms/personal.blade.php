
    <input type="hidden" name="id" value="{{ $employee->id ?? '' }}">

    <div class="modal-body">

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>First Name</label>
                <input type="text" name="first_name"
                       class="form-control"
                       value="{{ $employee->first_name }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Last Name</label>
                <input type="text" name="last_name"
                       class="form-control"
                       value="{{ $employee->last_name }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Phone</label>
                <input type="text" name="phone"
                       class="form-control"
                       value="{{ $employee->phone }}">
            </div>

              <div class="col-md-6 mb-3">
                <label>Emergency Phone</label>
                <input type="text" name="emergency_phone"
                       class="form-control"
                       value="{{ $employee->emergency_phone }}">
            </div>

              <div class="col-md-6 mb-3">
                <label>personal Email</label>
                <input type="text" name="personal_email"
                       class="form-control"
                       value="{{ $employee->personal_email }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Date of Birth</label>
                <input type="date" name="dob"
                       class="form-control"
                       value="{{ $employee->dob }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Gender</label>
                <select name="gender" class="form-control">
                    <option value="male" {{ $employee->gender=='male'?'selected':'' }}>Male</option>
                    <option value="female" {{ $employee->gender=='female'?'selected':'' }}>Female</option>
                </select>
            </div>

        </div>

    </div>



