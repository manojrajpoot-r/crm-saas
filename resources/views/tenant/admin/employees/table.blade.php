<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>User</th>
            <th>Department</th>
            <th>Designation</th>
            <th>Manager</th>
            <th>DOB</th>
            <th>Join Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody id="tableBody">
        @foreach($employees as $key => $t)
        <tr>
            <td>{{ $employees->firstItem() + $key }}</td>

            <td>{{ $t->user->name ?? '-' }}</td>
            <td>{{ $t->department->name ?? '-' }}</td>
            <td>{{ $t->designation->name ?? '-' }}</td>
            <td>
                {{ $t->manager
                    ? $t->manager->first_name.' '.$t->manager->last_name
                    : '-' }}
            </td>

            <td>{{ format_date($t->dob) }}</td>
            <td>{{ format_date($t->join_date) }}</td>

            {{-- STATUS --}}
            <td>
                @if(canAccess('status_hrs'))
                    <button
                        class="btn btn-sm {{ $t->status ? 'btn-success':'btn-danger' }} statusBtn"
                        data-url="{{ tenantRoute('employees.status',null,['id'=>$t->id]) }}">
                        {{ $t->status ? 'Active':'Inactive' }}
                    </button>
                @else
                    <span class="badge bg-secondary">No Access</span>
                @endif
            </td>

            {{-- ACTION --}}
            <td>
                @if(canAccess('edit_hrs'))
                    <a href="{{ tenantRoute('employees.edit',null,['id'=>$t->id]) }}"
                       class="btn btn-info btn-sm">Edit</a>
                @endif

                @if(canAccess('delete_hrs'))
                    <button class="btn btn-danger btn-sm deleteBtn"
                        data-url="{{ tenantRoute('employees.delete',null,['id'=>$t->id]) }}">
                        Delete
                    </button>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-3">
    {{ $employees->links('pagination::bootstrap-5') }}
</div>
