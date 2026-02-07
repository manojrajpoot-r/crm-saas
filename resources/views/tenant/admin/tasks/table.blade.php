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

    <tbody id="tableBody">
        @forelse($tasks as $key => $t)
        <tr>
            <td>{{ $tasks->firstItem() + $key }}</td>

            <td>{{ $t->name ?? '-' }}</td>


           <td>
                <span class="badge bg-{{ match($t->status){
                    1=>'success',2=>'secondary',3=>'danger',default=>'dark'
                } }}">
                    {{ $t->status_text }}
                </span>
            </td>



        <td>
                @if(canAccess('status_tasks'))

                    @if($t->task_status == 0)
                        <button class="btn btn-sm btn-primary actionBtnTask"
                            data-url="{{ tenantRoute('tasks.status',null,['id'=>$t->id]) }}"
                            data-type="start">Start</button>

                    @elseif($t->task_status == 1)
                        <button class="btn btn-sm btn-warning actionBtnTask"
                            data-url="{{ tenantRoute('tasks.status',null,['id'=>$t->id]) }}"
                            data-type="complete">Mark Complete</button>

                    @elseif($t->task_status == 2)
                        <button class="btn btn-sm btn-success actionBtnTask"
                            data-url="{{ tenantRoute('tasks.status',null,['id'=>$t->id]) }}"
                            data-type="approve">Approve</button>

                        <button class="btn btn-sm btn-danger actionBtnTask"
                            data-url="{{ tenantRoute('tasks.status',null,['id'=>$t->id]) }}"
                            data-type="decline">Decline</button>
                    @else
                        <span class="badge bg-secondary">{{ $t->task_status_text }}</span>
                    @endif

                @else
                    <span class="badge bg-secondary">No Access</span>
                @endif
        </td>





            <td>
                @if(canAccess('edit_tasks'))
                    <button class="btn btn-info btn-sm editBtn"
                        data-url="{{ tenantRoute('tasks.edit',null,['id'=>$t->id]) }}">
                        Edit
                    </button>
                @endif

                @if(canAccess('delete_tasks'))
                    <button class="btn btn-danger btn-sm deleteBtn"
                        data-url="{{ tenantRoute('tasks.delete',null,['id'=>$t->id]) }}">
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
