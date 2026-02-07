<table class="table table-bordered">
    <thead>
        <tr>
            <th>Task</th>
            <th>Project</th>
            <th>Module</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Start</th>
            <th>End</th>
        </tr>
    </thead>
    <tbody>
        @forelse($mytasks as $task)
            <tr>
                <td>{{ $task->name }}</td>
                <td>{{ $task->project->name ?? '-' }}</td>
                <td>{{ $task->module->title ?? '-' }}</td>
                <td>{{ ucfirst($task->priority) }}</td>


             <td>
                @if(canAccess('status_mytasks'))
                                @if($task->task_status == 1)
                                    <button class="btn btn-sm btn-warning statusBtn"
                                    data-url="{{ tenantRoute('mytasks.status',null,['id'=>$task->id]) }}"
                                        data-id="{{ $task->id }}">
                                        Mark Completed
                                    </button>
                                @else
                                    <span class="badge bg-info">{{ $task->task_status_text }}</span>
                                @endif
                @endif
            </td>




                <td>{{ format_date($task->start_date) }}</td>
                <td>{{ format_date($task->end_date) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No tasks assigned</td>
            </tr>
        @endforelse
    </tbody>
</table>

