<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
              <th>Department Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

  <tbody id="tableBody">
        @foreach($designations as $key => $t)
        <tr>
            <td>{{ $designations->firstItem() + $key }}</td>
            <td>{{ $t->name }}</td>
            <td>{{ $t->department->name }}</td>

            <td>
                @if(canAccess('designations_status'))
                    <button
                        class="btn btn-sm {{ $t->status ? 'btn-success':'btn-danger' }} statusBtn"
                        data-url="{{ tenantRoute('designations.status',$t->id) }}">
                        {{ $t->status ? 'Active':'Inactive' }}
                    </button>
                @else
                    <span class="badge bg-secondary">No Access</span>
                @endif
            </td>

            <td>
                @if(canAccess('edit_designations'))
                    <button class="btn btn-info btn-sm editBtn"
                        data-url="{{ tenantRoute('designations.edit',$t->id) }}">
                        Edit
                    </button>
                @endif


                @if(canAccess('delete_departments'))
                    <button class="btn btn-danger btn-sm deleteBtn"
                        data-url="{{ tenantRoute('designations.delete',$t->id) }}">
                        Delete
                    </button>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-3">
   {{ $designations->links('pagination::bootstrap-5') }}

</div>
