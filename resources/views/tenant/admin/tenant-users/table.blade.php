<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Profile</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Role</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

  <tbody id="tableBody">
        @foreach($users as $key => $t)
        <tr>
            <td>{{ $users->firstItem() + $key }}</td>

            <td>
                <img src="{{ $t->profile_url }}" alt="profile" class="rounded-circle" width="30" height="30">

            </td>

            <td>{{ $t->name }}</td>
            <td>{{ $t->email }}</td>
            <td>{{ $t->phone }}</td>
            <td>  {{ $t->role_name }}</td>

            <td>
                @if(canAccess('users_status'))
                    <button
                        class="btn btn-sm {{ $t->status ? 'btn-success':'btn-danger' }} statusBtn"
                        data-url="{{ tenantRoute('users.status',$t->id) }}">
                        {{ $t->status ? 'Active':'Inactive' }}
                    </button>
                @else
                    <span class="badge bg-secondary">No Access</span>
                @endif
            </td>

            <td>
                @if(canAccess('edit_users'))
                    <button class="btn btn-info btn-sm editBtn"
                        data-url="{{ tenantRoute('users.edit',$t->id) }}">
                        Edit
                    </button>
                @endif

                @if(canAccess('change_users_password'))
                    <button class="btn btn-warning btn-sm changePasswordBtn"
                        data-url="{{ tenantRoute('users.password.change',$t->id) }}">
                        Change Password
                    </button>
                @endif

                @if(canAccess('delete_users'))
                    <button class="btn btn-danger btn-sm deleteBtn"
                        data-url="{{ tenantRoute('users.delete',$t->id) }}">
                        Delete
                    </button>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-3">
   {{ $users->links('pagination::bootstrap-5') }}

</div>
