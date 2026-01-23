<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Code</th>
            <th>Type</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody id="tableBody">
        @foreach($assets as $key => $t)
        <tr>
            <td>{{ $assets->firstItem() + $key }}</td>
            <td>{{ $t->name }}</td>
            <td>{{ $t->code }}</td>
            <td>{{ $t->type }}</td>


            {{-- STATUS --}}
            <td>
                @if(!canAccess('status_assets'))
                    <span class="badge bg-secondary">No Access</span>
                @else
                    @php
                        if ($t->status == 1) {
                            $class = 'btn-success';
                            $text  = 'Available';
                        } else {
                            $class = 'btn-warning';
                            $text  = 'Assigned';
                        }
                    @endphp

                    <button
                        class="btn btn-sm {{ $class }} statusBtn"
                        data-url="{{ tenantRoute('asset_assigns.status', $t->id) }}">
                        {{ $text }}
                    </button>
                @endif
            </td>


            {{-- ACTION --}}
            <td>
                @if(canAccess('edit_assets'))
                    <button class="btn btn-info btn-sm editBtn"
                        data-url="{{ tenantRoute('asset_assigns.edit',$t->id) }}">
                        Edit
                    </button>
                @endif

                @if(canAccess('delete_assets'))
                    <button class="btn btn-danger btn-sm deleteBtn"
                        data-url="{{ tenantRoute('asset_assigns.delete',$t->id) }}">
                        Delete
                    </button>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-3">
    {{ $assets->links('pagination::bootstrap-5') }}
</div>
