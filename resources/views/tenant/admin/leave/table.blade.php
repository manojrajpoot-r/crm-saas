<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Employee</th>
            <th>Leave Type</th>
            <th>Dates</th>
            <th>Total Days</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse($leaves as $key => $r)
        <tr>
            <td>{{ $leaves->firstItem() + $key }}</td>

            <td>{{ $r->user->name ?? '-' }}</td>

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
                {{ ($r->start_date) }}
                to
                {{ ($r->end_date) }}
            </td>

            <td>{{ $r->total_days }}</td>

            {{-- STATUS --}}
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

            {{-- ACTION --}}
            <td>
                {{-- Approve / Reject (only pending) --}}
                @if($r->status === 'pending')
                    <button class="btn btn-success btn-sm approve"
                        data-id="{{ $r->id }}">
                        Approve
                    </button>

                    <button class="btn btn-danger btn-sm reject"
                        data-id="{{ $r->id }}">
                        Reject
                    </button>
                @endif

                @if(canAccess('edit_leaves'))
                    <button class="btn btn-info btn-sm editBtn"
                        data-url="{{ tenantRoute('leaves.edit',$r->id) }}">
                        Edit
                    </button>
                @endif

                @if(canAccess('delete_leaves'))
                    <button class="btn btn-danger btn-sm deleteBtn"
                        data-url="{{ tenantRoute('leaves.delete',$r->id) }}">
                        Delete
                    </button>
                @endif
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
