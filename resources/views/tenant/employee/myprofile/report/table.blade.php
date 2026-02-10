<table class="table table-bordered align-middle">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>User Name</th>
            <th>Report Date</th>
            <th>Project</th>
            <th>Review</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
    @forelse($reports as $key => $r)
        <tr>

            <td>{{ $reports->firstItem() + $key }}</td>


            <td>{{ $r->user->name ?? '-' }}</td>


            <td>{{ \Carbon\Carbon::parse($r->report_date)->format('d M Y') }}</td>


            <td>
                @if($r->projects->count() === 1)
                    {{ optional($r->projects->first()->project)->name }}
                @elseif($r->projects->count() > 1)
                    <span class="badge bg-info">
                        Multiple ({{ $r->projects->count() }})
                    </span>
                @else
                    Other
                @endif
            </td>


            <td>
                @if(!empty($r->admin_comment))
                    <span class="badge bg-danger">
                        1 Review
                    </span>
                @else
                    <span class="text-muted">No Review</span>
                @endif
            </td>



            <td>
                @php
                    $statusMap = [
                        'draft'     => 'secondary',
                        'submitted' => 'warning',
                        'approved'  => 'success',
                        'rejected'  => 'danger'
                    ];
                @endphp

                <span class="badge bg-{{ $statusMap[$r->status] ?? 'secondary' }}">
                    {{ ucfirst($r->status) }}
                </span>
            </td>


            <td class="d-flex gap-1 flex-wrap">



                    <a class="btn btn-sm btn-info"
                       href="{{ tenantRoute('employee.myreports.show', null, ['id'=>base64_encode($r->id)]) }}">
                        View
                    </a>



                @if(canAccess('edit_myreports') && $r->status === 'draft')
                    <a class="btn btn-sm btn-primary"
                       href="{{ tenantRoute('employee.myreports.edit', null, ['id'=>base64_encode($r->id)]) }}">
                        Edit
                    </a>
                @endif


                @if(canAccess('delete_myreports') && $r->status === 'draft')
                    <button
                        class="btn btn-sm btn-danger deleteBtn"
                        data-url="{{ tenantRoute('employee.myreports.delete', null, ['id'=>$r->id]) }}">
                        Delete
                    </button>
                @endif


                @if(canAccess('view_all_myreports') && $r->status === 'submitted')
                    <button
                        class="btn btn-sm btn-success actionBtn"
                        data-status="approved"
                        data-url="{{ tenantRoute('employee.myreports.status', null, ['id'=>$r->id]) }}"
                         data-status="approved">
                        Approve
                    </button>

                    <button
                        class="btn btn-sm btn-danger actionBtn"
                        data-status="rejected"
                        data-url="{{ tenantRoute('employee.myreports.status', null, ['id'=>$r->id]) }}"
                        data-status="rejected">
                        Reject
                    </button>
                @endif

            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center text-muted">
                No reports found
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

<div class="mt-3">
    {{ $reports->links('pagination::bootstrap-5') }}
</div>
