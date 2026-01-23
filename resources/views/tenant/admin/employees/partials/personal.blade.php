   <div class="card mb-4">
                    <div class="card-header fw-bold">
                        Employee Details {{ $employee ? '(Edit Employee)' : '(New Employee)' }}
                    </div>

                    <div class="card-body">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Profile *</label>
                                <input type="file" class="form-control" name="profile"
                                    value="{{ old('profile', $employee->profile ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">First Name *</label>
                                <input type="text" class="form-control" name="first_name"
                                    value="{{ old('first_name', $employee->first_name ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="last_name"
                                    value="{{ old('last_name', $employee->last_name ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone *</label>
                                <input type="text" class="form-control" name="phone"
                                    value="{{ old('phone', $employee->phone ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Emergency Phone</label>
                                <input type="text" class="form-control" name="emergency_phone"
                                    value="{{ old('emergency_phone', $employee->emergency_phone ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">DOB</label>
                                <input type="date" class="form-control" name="dob"
                                    value="{{ old('dob', $employee->dob ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Gender</label>
                                <select class="form-select" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ ($employee->gender ?? '')=='Male'?'selected':'' }}>Male</option>
                                    <option value="Female" {{ ($employee->gender ?? '')=='Female'?'selected':'' }}>Female</option>
                                    <option value="Other" {{ ($employee->gender ?? '')=='Other'?'selected':'' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Department</label>
                                    <select name="department_id" class="form-select">
                                        <option value="">Select Department</option>
                                        @if (count($departments) > 0)
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}" {{ ($employee->department_id ?? '')==$department->id?'selected':'' }}>{{ $department->name }}</option>
                                            @endforeach
                                        @endif


                                    </select>
                            </div>

                        <div class="col-md-6">
                            <label class="form-label">Designation</label>
                            <select name="designation_id" class="form-select">
                                <option value="">Select Designation</option>
                                @if (count($designations) > 0)
                                    @foreach ($designations as $designation)
                                        <option value="{{ $designation->id }}" {{ ($employee->designation_id ?? '')==$designation->id?'selected':'' }}>{{ $designation->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>


                        <div class="col-md-6">
                            <label class="form-label">Report To</label>
                            <select name="report_to" class="form-select">
                                <option value="">No Manager</option>
                                @if(count($managers) > 0)
                                    @foreach($managers as $manager)
                                        <option value="{{ $manager->id }}"
                                            {{ old('report_to', $employee->report_to ?? '') == $manager->id ? 'selected' : '' }}>
                                            {{ $manager->first_name }} {{ $manager->last_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        {{-- end --}}
                        </div>
                    </div>
                </div>
   {{-- ================= ACCOUNT DETAILS ================= --}}
                <div class="card mb-4">
                    <div class="card-header fw-bold">Account Details</div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Employee ID *</label>
                                <input type="text" class="form-control"
                                    name="employee_id"
                                    value="{{ old('employee_id', $employee->employee_id ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Join Date</label>
                                <input type="date" class="form-control"
                                    name="join_date"
                                    value="{{ old('join_date', $employee->join_date ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Corporate Email *</label>
                                <input type="email" class="form-control"
                                    name="corporate_email"
                                    value="{{ old('corporate_email', $employee->corporate_email ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Personal Email</label>
                                <input type="email" class="form-control"
                                    name="personal_email"
                                    value="{{ old('personal_email', $employee->personal_email ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>
