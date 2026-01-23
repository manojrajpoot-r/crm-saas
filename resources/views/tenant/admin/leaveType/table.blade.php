<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Paid</th>
            <th>Rules</th>
            <th>Color</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse($leaveTypes as $key => $t)
        <tr>
            <td>{{ $leaveTypes->firstItem() + $key }}</td>

            <td>{{ $t->name }}</td>

            {{-- PAID --}}
            <td>
                @if($t->is_paid)
                    <span class="badge bg-success">Paid</span>
                @else
                    <span class="badge bg-danger">Unpaid</span>
                @endif
            </td>

            {{-- RULES --}}
            <td>
                @php
                    $rules = [];
                    if ($t->allow_half)  $rules[] = 'Half';
                    if ($t->allow_short) $rules[] = 'Short';
                @endphp
                {{ $rules ? implode(', ', $rules) : '-' }}
            </td>

            {{-- COLOR --}}
            <td>
                @if($t->color)
                    <span class="badge" style="background:{{ $t->color }}">
                        {{ $t->color }}
                    </span>
                @else
                    -
                @endif
            </td>

            {{-- STATUS --}}
            <td>
                @if(!canAccess('status_leave_types'))
                    -
                @else
                    <button
                        class="btn btn-sm {{ $t->status ? 'btn-success':'btn-danger' }} statusBtn"
                        data-url="{{ tenantRoute('leaveTypes.status',$t->id) }}">
                        {{ $t->status ? 'Active':'Inactive' }}
                    </button>
                @endif
            </td>

            {{-- ACTION --}}
            <td>
                @if(canAccess('edit_leave_types'))
                    <button class="btn btn-info btn-sm editBtn"
                        data-url="{{ tenantRoute('leaveTypes.edit',$t->id) }}">
                        Edit
                    </button>
                @endif

                @if(canAccess('delete_leave_types'))
                    <button class="btn btn-danger btn-sm deleteBtn"
                        data-url="{{ tenantRoute('leaveTypes.delete',$t->id) }}">
                        Delete
                    </button>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center">No Leave Types Found</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-3">
    {{ $leaveTypes->links('pagination::bootstrap-5') }}
</div>
