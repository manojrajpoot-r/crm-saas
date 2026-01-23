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
        @foreach($roles as $key => $t)
        <tr>
            <td>{{ $roles->firstItem() + $key }}</td>



            <td>{{ $t->name }}</td>


            <td>
                @if(canAccess('roles_status'))
                    <button
                        class="btn btn-sm {{ $t->status ? 'btn-success':'btn-danger' }} statusBtn"
                        data-url="{{ tenantRoute('roles.status',$t->id) }}">
                        {{ $t->status ? 'Active':'Inactive' }}
                    </button>
                @else
                    <span class="badge bg-secondary">No Access</span>
                @endif
            </td>

            <td>
                @if(canAccess('edit_roles'))
                    <button class="btn btn-info btn-sm editBtn"
                        data-url="{{ tenantRoute('roles.edit',$t->id) }}">
                        Edit
                    </button>
                @endif




                @if(canAccess('delete_roles'))
                    <button class="btn btn-danger btn-sm deleteBtn"
                        data-url="{{ tenantRoute('roles.delete',$t->id) }}">
                        Delete
                    </button>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-3">
   {{ $roles->links('pagination::bootstrap-5') }}

</div>
