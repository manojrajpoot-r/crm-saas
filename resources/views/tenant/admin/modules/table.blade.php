<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Created At</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody id="tableBody">
        @forelse($modules as $key => $t)
        <tr>
            <td>{{ $modules->firstItem() + $key }}</td>

            <td>{{ ($t->created_at) }}</td>

            <td>{{ ($t->start_date ?? $t->created_at) }}</td>

            <td>{{ ($t->end_date ?? $t->created_at) }}</td>

            {{-- STATUS --}}
            <td>
                @if(canAccess('module status'))
                    @php
                        $class = $t->status ? 'btn-success' : 'btn-danger';
                        $text  = $t->status ? 'Active' : 'Inactive';
                    @endphp

                    <button class="btn btn-sm {{ $class }} statusBtn"
                        data-url="{{ tenantRoute('modules.status',null,['id'=>$t->id]) }}">
                        {{ $text }}
                    </button>
                @else
                    <span class="badge bg-secondary">No Access</span>
                @endif
            </td>

            {{-- ACTION --}}
            <td>
                @if(canAccess('module edit'))
                    <button class="btn btn-info btn-sm editBtn"
                        data-url="{{ tenantRoute('modules.edit',null,['id'=>$t->id]) }}">
                        Edit
                    </button>
                @endif

                @if(canAccess('module delete'))
                    <button class="btn btn-danger btn-sm deleteBtn"
                        data-url="{{ tenantRoute('modules.delete',null,['id'=>$t->id]) }}">
                        Delete
                    </button>
                @endif

                @if(!canAccess('module edit') && !canAccess('module delete'))
                    No Action
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">No Modules Found</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-3">
    {{ $modules->links('pagination::bootstrap-5') }}
</div>
