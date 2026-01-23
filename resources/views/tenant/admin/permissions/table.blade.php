<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Group</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

  <tbody id="tableBody">
        @foreach($permissions as $key => $t)
        <tr>
            <td>{{ $permissions->firstItem() + $key }}</td>
            <td>{{ $t->name }}</td>
            <td>{{ $t->group }}</td>
            <td>
                @if(canAccess('permissions_status'))
                    <button
                        class="btn btn-sm {{ $t->status ? 'btn-success':'btn-danger' }} statusBtn"
                        data-url="{{ tenantRoute('permissions.status',$t->id) }}">
                        {{ $t->status ? 'Active':'Inactive' }}
                    </button>
                @else
                    <span class="badge bg-secondary">No Access</span>
                @endif
            </td>

            <td>
                @if(canAccess('edit_permissions'))
                    <button class="btn btn-info btn-sm editBtn"
                        data-url="{{ tenantRoute('permissions.edit',$t->id) }}">
                        Edit
                    </button>
                @endif


                @if(canAccess('delete_permissions'))
                    <button class="btn btn-danger btn-sm deleteBtn"
                        data-url="{{ tenantRoute('permissions.delete',$t->id) }}">
                        Delete
                    </button>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-3">
   {{ $permissions->links('pagination::bootstrap-5') }}

</div>
