<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Domain</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

  <tbody id="tableBody">
        @foreach($tenants as $key => $t)
        <tr>
            <td>{{ $tenants->firstItem() + $key }}</td>
            <td>{{ $t->name }}</td>
            <td>{{ $t->domain }}</td>
            <td>
                @if(canAccess('tenants_status'))
                    <button
                        class="btn btn-sm {{ $t->status ? 'btn-success':'btn-danger' }} statusBtn"
                        data-url="{{ tenantRoute('tenants.status',$t->id) }}">
                        {{ $t->status ? 'Active':'Inactive' }}
                    </button>
                @else
                    <span class="badge bg-secondary">No Access</span>
                @endif
            </td>

            <td>
                @if(canAccess('edit_tenants'))
                    <button class="btn btn-info btn-sm editBtn"
                        data-url="{{ tenantRoute('tenants.edit',$t->id) }}">
                        Edit
                    </button>
                @endif


                @if(canAccess('delete_tenants'))
                    <button class="btn btn-danger btn-sm deleteBtn"
                        data-url="{{ tenantRoute('tenants.delete',$t->id) }}">
                        Delete
                    </button>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-3">
   {{ $tenants->links('pagination::bootstrap-5') }}

</div>
