<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>User Name</th>
            <th>Report Date</th>
            <th>Project Name</th>
             <th>Review</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
   <tbody>
@foreach($reports as $key => $r)
<tr>
    <td>{{ $reports->firstItem() + $key }}</td>
    <td>{{ $r->user->name ?? '-' }}</td>
    <td>{{ \Carbon\Carbon::parse($r->report_date)->format('d M Y') }}</td>
    <td>{{ $r->project->name ?? 'Multiple / Other' }}</td>

    <td>
        {{0 }}
    </td>

    <td>
        <span class="badge bg-{{
            $r->status == 'approved' ? 'success' :
            ($r->status == 'rejected' ? 'danger' :
            ($r->status == 'submitted' ? 'warning' : 'secondary'))
        }}">
            {{ ucfirst($r->status) }}
        </span>
    </td>


                    <td class="d-flex gap-1">
                        @if(canAccess('view_reports'))
                            <a class="btn btn-sm btn-info"
                            href="{{ tenantRoute('employee.myreports.show', null, ['id'=>base64_encode($r->id)]) }}">
                                View
                            </a>
                        @endif

                    {{-- Edit (Draft only) --}}
                    @if(canAccess('edit_reports') && $r->status == 'draft')
                        <a class="btn btn-sm btn-primary"
                           href="{{ tenantRoute('employee.myreports.edit', null, ['id'=>base64_encode($r->id)]) }}">
                            Edit
                        </a>
                    @endif

                    {{-- Delete (Draft only) --}}
                    @if(canAccess('delete_reports') && $r->status == 'draft')
                        <button
                            class="btn btn-sm btn-danger deleteBtn"
                            data-url="{{ tenantRoute('employee.myreports.delete',['id'=>$r->id]) }}">
                            Delete
                        </button>
                    @endif

                    {{-- Approve / Reject (Admin) --}}
                    @if(canAccess('status_myreports') && $r->status == 'submitted')
                        <button
                            class="btn btn-sm btn-success statusBtn"
                            data-status="approved"
                            data-url="{{ tenantRoute('reports.status',['id'=>$r->id]) }}">
                            Approve
                        </button>

                        <button
                            class="btn btn-sm btn-danger statusBtn"
                            data-status="rejected"
                            data-url="{{ tenantRoute('myreports.status',['id'=>$r->id]) }}">
                            Reject
                        </button>
                    @endif

                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-3">
    {{ $reports->links('pagination::bootstrap-5') }}
</div>
