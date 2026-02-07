@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
 @include('tenant.admin.projects.tabs',['id'=>$project->id])
   @include('tenant.includes.universal-modal')
       {{-- ADD BUTTON --}}
        @if(canAccess('create_tasks'))
            <button id="addBtn" class="btn btn-primary mb-3">
                Add Task
            </button>

        @endif
         @include('tenant.includes.universal-pagination', [
                'url' => tenantRoute('tasks.index', null, base64_encode($project->id)),
                'wrapperId' => 'tasksTable',
                'content' => view('tenant.admin.tasks.table', [
                    'tasks' => $tasks
                ])
            ])
    </div>
</div>
@endsection
@push('scripts')
    @include('tenant.includes.universal-scripts')
    <script>
     $(document).ready(function () {
         $("#addBtn").click(function () {
            let priorityOptions = "normal|Normal,high|High,low|Low";

            const MODULES = @json($moduleList);
            const USERS    = @json($userList);
            let moduleOptions = MODULES.map(m => `${m.id}|${m.title}`).join(',');
            let userOptions = USERS.map(u => `${u.id}|${u.name}`).join(',');


            let fields = {
                project_id: { type: "hidden", value: "{{ $project->id }}" },
                module_id: 'select:' + moduleOptions,
                name: 'text',
                description: 'textarea',
                start_date: 'date',
                end_date: 'date',
                priority: 'select:' + priorityOptions,
                assigned_to: 'select:' + userOptions
            };

            let storeUrl = "{{ tenantRoute('tasks.store') }}";

            $("#universalForm").attr("action", storeUrl);

            loadForm(fields, "Add Task");

                 $('#globalModal').off('shown.bs.modal').on('shown.bs.modal', function () {
                    initModalPlugins();
                });
        });
    });




    $(document).on('click', '.changeStatus', function () {

       let id   = $(this).data('id');
        let type = $(this).data('type');

        let url = "{{ tenantRoute('tasks.status', null, ':id') }}";
        url = url.replace(':id', id);

        $.post(url, {
            _token: "{{ csrf_token() }}",
            type: type
        }, function () {
            $('#universalTable').DataTable().ajax.reload(null, false);
        });
    });


</script>

@endpush
