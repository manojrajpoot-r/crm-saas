<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

  <tbody id="tableBody">
        @foreach($departments as $key => $t)
        <tr>
            <td>{{ $departments->firstItem() + $key }}</td>
            <td>{{ $t->name }}</td>

            <td>
                @if(canAccess('departments_status'))
                    <button
                        class="btn btn-sm {{ $t->status ? 'btn-success':'btn-danger' }} statusBtn"
                        data-url="{{ tenantRoute('departments.status',$t->id) }}">
                        {{ $t->status ? 'Active':'Inactive' }}
                    </button>
                @else
                    <span class="badge bg-secondary">No Access</span>
                @endif
            </td>

            <td>
                @if(canAccess('edit_departments'))
                    <button class="btn btn-info btn-sm editBtn"
                        data-url="{{ tenantRoute('departments.edit',$t->id) }}">
                        Edit
                    </button>
                @endif


                @if(canAccess('delete_departments'))
                    <button class="btn btn-danger btn-sm deleteBtn"
                        data-url="{{ tenantRoute('departments.delete',$t->id) }}">
                        Delete
                    </button>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-3">
   {{ $departments->links('pagination::bootstrap-5') }}

</div>
