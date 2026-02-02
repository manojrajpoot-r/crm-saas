
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm text-center">
            <small>Total Leaves</small>
            <h4 class="fw-bold">{{ $selfStats['total'] }}</h4>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm text-center text-warning">
            <small>Pending</small>
            <h4 class="fw-bold">{{ $selfStats['pending'] }}</h4>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm text-center text-success">
            <small>Approved</small>
            <h4 class="fw-bold">{{ $selfStats['approved'] }}</h4>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm text-center text-danger">
            <small>Rejected</small>
            <h4 class="fw-bold">{{ $selfStats['rejected'] }}</h4>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
@foreach($leaveTypes as $type)
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <span>{{ $type->name }}</span>
                <span class="badge"
                      style="background:{{ $type->color }}">
                    {{ $selfStats['types'][$type->id] ?? 0 }}
                </span>
            </div>
        </div>
    </div>
@endforeach
</div>



<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Leave Type</th>
            <th>Dates</th>
            <th>Total Days</th>
             <th>Session</th>
            <th>Subject</th>
            <th>Status</th>
             <th>Approved By</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody id="tableBody">
        @forelse($leaves as $key => $r)
        <tr>
            <td>{{ $leaves->firstItem() + $key }}</td>
            <td>
                @if($r->leaveType)
                    <span class="badge"
                        style="background:{{ $r->leaveType->color }}">
                        {{ $r->leaveType->name }}
                    </span>
                @else
                    -
                @endif
            </td>

           <td>
                {{ format_date($r->start_date) }}

                @if(!empty($r->end_date) && $r->start_date != $r->end_date)
                    to {{ format_date($r->end_date) }}
                @endif
            </td>

            <td>{{ $r->total_days }}</td>
             <td>{{ ucwords($r->session) }}</td>
             <td>{{ $r->subject }}</td>

            {{-- STATUS BADGE --}}
            <td>
                @php
                    $class = match($r->status){
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'warning'
                    };
                @endphp
                <span class="badge bg-{{ $class }}">
                    {{ ucfirst($r->status) }}
                </span>
            </td>

            <td>
            <img src="{{ $r->approvedByUser?->profile_url ?? asset('images/default-profile.png') }}"
                class="rounded-circle me-2" width="35" height="35">
            <span>{{ $r->approvedByUser?->name ?? '-' }}</span>
            </td>
            <td>
               <button class="btn btn-secondary btn-sm viewBtn"
                    data-url="{{ tenantRoute('leaves.show', null, $r->id) }}">
                    View
                </button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center">No Leave Requests Found</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-3">
    {{ $leaves->links('pagination::bootstrap-5') }}
</div>
