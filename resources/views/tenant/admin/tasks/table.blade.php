<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Status</th>
            <th>Complete</th>
            <th>Approve</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse($tasks as $key => $t)
        <tr>
            <td>{{ $tasks->firstItem() + $key }}</td>

            <td>{{ $t->title ?? '-' }}</td>

            {{-- STATUS TEXT --}}
            <td>
                @php
                    $map = [
                        1 => ['Completed', 'success'],
                        2 => ['Created', 'secondary'],
                        3 => ['Declined', 'danger'],
                    ];

                    [$text, $color] = $map[$t->status] ?? ['Unknown', 'dark'];
                @endphp

                <span class="badge bg-{{ $color }}">{{ $text }}</span>
            </td>

            {{-- COMPLETE --}}
            <td>
                @if(!canAccess('status_tasks'))
                    -
                @elseif($t->is_completed)
                    <span class="badge bg-success">Completed</span>
                @else
                    <button class="btn btn-sm btn-warning changeStatus"
                        data-id="{{ $t->id }}"
                        data-type="complete">
                        Mark Complete
                    </button>
                @endif
            </td>

            {{-- APPROVE --}}
            <td>
                @if(!canAccess('status_tasks'))
                    -
                @elseif($t->is_approved)
                    <span class="badge bg-primary">Approved</span>
                @else
                    <button class="btn btn-sm btn-info changeStatus"
                        data-id="{{ $t->id }}"
                        data-type="approve">
                        Approve
                    </button>
                @endif
            </td>

            {{-- ACTION --}}
            <td>
                @if(canAccess('edit_tasks'))
                    <button class="btn btn-info btn-sm editBtn"
                        data-url="{{ tenantRoute('tasks.edit',$t->id) }}">
                        Edit
                    </button>
                @endif

                @if(canAccess('delete_tasks'))
                    <button class="btn btn-danger btn-sm deleteBtn"
                        data-url="{{ tenantRoute('tasks.delete',$t->id) }}">
                        Delete
                    </button>
                @endif

                @if(!canAccess('edit_tasks') && !canAccess('delete_tasks'))
                    <span class="badge bg-secondary">No Action</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">No Tasks Found</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-3">
    {{ $tasks->links('pagination::bootstrap-5') }}
</div>
