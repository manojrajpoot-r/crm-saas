<div class="card">
    <div class="card-body">
        <div class="row align-items-center">

            {{-- LEFT : PROFILE IMAGE --}}
            <div class="col-md-4 text-center">
                <div id="profileImageWrapper">
                    @if($employee->profile)
                        <img src="{{ asset('uploads/employees/profile/'.$employee->profile) }}"
                             class="rounded-circle mb-2"
                             width="120" height="120">
                    @else
                        <div class="profile-circle">
                            {{ strtoupper(substr($employee->first_name,0,1)) }}
                        </div>
                    @endif
                </div>

               <label for="profileImage" class="edit-icon">
                        <i class="fas fa-camera"></i>
                    </label>

                    <input type="file" id="profileImage" hidden>
            </div>

            {{-- RIGHT : DETAILS --}}
            <div class="col-md-8">
                <h5>{{ ucwords($employee->first_name) }} {{ ucwords($employee->last_name) }}</h5>

                <p class="text-muted mb-1">
                    {{ ucwords(optional($employee->designation)->name) }}
                </p>

                <p class="mb-1">
                    <strong>Employee ID:</strong> {{ $employee->employee_id }}
                </p>

                <p class="mb-1">
                    <strong>Date of Join:</strong>
                    {{ \Carbon\Carbon::parse($employee->join_date)->format('d M Y') }}
                    <span class="text-muted">
                        ({{ \Carbon\Carbon::parse($employee->join_date)->diffForHumans(null, true) }})
                    </span>
                </p>

                <p class="mb-1">
                    <strong>Office Email:</strong> {{ $employee->corporate_email }}
                </p>

                <p class="mb-0">
                  <strong>Status:</strong>
                    <span class="badge {{ $employee->status == 1 ? 'bg-success' : 'bg-danger' }}">
                        {{ $employee->status == 1 ? 'Active' : 'Inactive' }}
                    </span>

                </p>
            </div>

        </div>
    </div>
</div>

