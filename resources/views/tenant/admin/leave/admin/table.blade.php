



<div class="accordion" id="leaveAccordion">

@foreach($users as $user)
@php
    $stats = $userStats[$user->id];
    $userLeaves = $user->leaves;
    $uid = Str::slug($stats['name'].'-'.$user->id);
@endphp



<div class="accordion-item mb-3">
    <h2 class="accordion-header">
        <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#user-{{ $uid }}">
            <strong>{{ ucwords($stats['name']) }}</strong>
            <span class="ms-2 text-muted">
                ({{ $stats['total'] }} Leaves)
            </span>
        </button>
    </h2>

    <div id="user-{{ $uid }}" class="accordion-collapse collapse">
        <div class="accordion-body p-0">

            {{-- USER SUMMARY CARDS --}}
            <div class="px-3 pt-3">
                <div class="row g-2 mb-3">
                    <div class="col-md-3">
                        <div class="card shadow-sm text-center">
                            <small>Total</small>
                            <strong>{{ $stats['total'] }}</strong>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card shadow-sm text-center text-warning">
                            <small>Pending</small>
                            <strong>{{ $stats['pending'] }}</strong>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card shadow-sm text-center text-success">
                            <small>Approved</small>
                            <strong>{{ $stats['approved'] }}</strong>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card shadow-sm text-center text-danger">
                            <small>Rejected</small>
                            <strong>{{ $stats['rejected'] }}</strong>
                        </div>
                    </div>
                </div>

                {{--  LEAVE TYPE CARDS (USER WISE) --}}
                {{-- <div class="row g-2 mb-3">
                    @foreach($leaveTypes as $type)
                        <div class="col-md-3">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <span>{{ $type->name }}</span>
                                    <span class="badge"
                                          style="background:{{ $type->color }}">
                                        {{ $stats['types'][$type->id] ?? 0 }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div> --}}
                <div class="row g-2 mb-3">
                    @foreach($leaveBalances[$user->id] as $lb)
                        <div class="col-md-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center">
                                    <strong style="color:{{ $lb['color'] }}">
                                        {{ $lb['name'] }}
                                    </strong>

                                    <div class="small text-muted">
                                        Allowed: {{ $lb['allowed'] }}
                                    </div>

                                    <div class="small text-success">
                                        Used: {{ $lb['used'] }}
                                    </div>

                                    <div class="small text-danger">
                                        Remaining: {{ $lb['remaining'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

            {{--  LEAVE TABLE --}}
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Total Days</th>
                        <th>Session</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Approved / Rejected</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($userLeaves as $r)
                    <tr>
                        <td>
                            <span class="badge"
                                  style="background:{{ $r->leaveType->color }}">
                                {{ ucwords($r->leaveType->name) }}
                            </span>
                        </td>

                        <td>
                            {{ format_date($r->start_date) }}
                            @if(!empty($r->end_date) && $r->start_date != $r->end_date)
                                to {{ format_date($r->end_date) }}
                            @endif
                        </td>


                        <td>{{ $r->total_days }}</td>
                        <td>
                            {{ ucwords($r->session ?? 'full days') }}
                        </td>
                        <td>{{ $r->subject }}</td>

                        <td>
                            <span class="badge bg-{{
                                $r->status == 'approved' ? 'success' :
                                ($r->status == 'rejected' ? 'danger' : 'warning')
                            }}">
                                {{ ucfirst($r->status) }}
                            </span>
                        </td>

                        <td>
                            @if(canAccess('status_leaves') && $r->status === 'pending')
                                <button class="btn btn-success btn-sm actionBtn"
                                    data-url="{{ tenantRoute('leaves.status', null, $r->id) }}"
                                    data-status="approved">Approve</button>

                                <button class="btn btn-danger btn-sm actionBtn"
                                    data-url="{{ tenantRoute('leaves.status', null, $r->id) }}"
                                    data-status="rejected">Reject</button>
                            @else

                                <img src="{{ $r->approvedByUser?->profile_url ?? asset('images/default-profile.png') }}"
                                    class="rounded-circle me-2" width="35" height="35">
                                <span>{{ $r->approvedByUser?->name ?? '-' }}</span>

                            @endif
                        </td>

                        <td>
                            <button class="btn btn-secondary btn-sm viewBtn"
                                data-url="{{ tenantRoute('leaves.show', null, $r->id) }}">
                                View
                            </button>

                            @if(canAccess('edit_leaves'))
                                <button class="btn btn-info btn-sm editBtn"
                                    data-url="{{ tenantRoute('leaves.edit', null, $r->id) }}">
                                    Edit
                                </button>
                            @endif

                            @if(canAccess('delete_leaves'))
                                <button class="btn btn-danger btn-sm deleteBtn"
                                    data-url="{{ tenantRoute('leaves.delete', null, $r->id) }}">
                                    Delete
                                </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
@endforeach

</div>


<div class="mt-3">
    {{ $users->links('pagination::bootstrap-5') }}
</div>
