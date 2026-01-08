@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
         @include('tenant.admin.projects.tabs',['id'=>$project->id])
        @include('tenant.includes.universal-modal')
        @include('tenant.includes.universal-form')

         @if (canAccess('task add'))
        <button id="addBtn" class="btn btn-primary mb-2 mt-3">Add Task</button>
        @endif
        @include('tenant.includes.universal-datatable')
    </div>
</div>


@endsection

@push('scripts')
    @include('tenant.includes.universal-scripts')

<script>
$(document).ready(function () {

    let PROJECT_ID = "{{ $project->id }}";

    let columns = [
        { data: 'DT_RowIndex', title: '#', orderable: false, searchable: false },
        {data:'name',title:'Task Name'},
        { data: 'status_text', title: 'Status'},
        { data: 'complete_btn', title: 'Completed' },
        { data: 'approve_btn', title: 'Approved' },
        { data: 'action', title: 'Action', orderable: false, searchable: false }
    ];

    // project_id ke sath task list
    let listUrl = "{{ currentGuard() === 'saas'? route('saas.tasks.list'): route('tenant.tasks.list') }}" + "?project_id=" + PROJECT_ID;

    loadDataTable(columns, listUrl);

    // =======================
    // ADD TASK
    // =======================
    $("#addBtn").click(function () {

        let userlist = "{{ currentGuard() === 'saas' ? route('saas.users.list'): route('tenant.users.list') }}";

        //  modules project-wise
        let modulelist = "{{ currentGuard() === 'saas' ? route('saas.modules.list') : route('tenant.modules.list', ['tenant' => currentTenant()]) }}" + "?project_id=" + PROJECT_ID;

        let priorityOptions = "normal|Normal,high|High,low|Low";

        $.when(
            $.get(userlist),
            $.get(modulelist)
        ).done(function (usersRes, modulesRes) {

            let users   = usersRes[0].data ?? [];
            let modules = modulesRes[0].data ?? [];

            let userOptions = users.map(u => `${u.id}|${u.name}`).join(',');
            let moduleOptions = modules.map(m => `${m.id}|${m.title}`).join(',');

            let fields = {
                project_id: "hidden",
                module_id: 'select:' + moduleOptions,
                name: 'text',
                description: 'textarea',
                start_date: 'date',
                end_date: 'date',
                priority: 'select:' + priorityOptions,
                assigned_to: 'select:' + userOptions
            };

            let storeUrl = "{{ currentGuard() === 'saas'? route('saas.tasks.store'): route('tenant.tasks.store', ['tenant' => currentTenant()]) }}";

            $("#universalForm").attr("action", storeUrl);

            loadForm(fields, "Add Task");

            //  auto set project id
            $('input[name="project_id"]').val(PROJECT_ID);

                // summer note
                initSummernote('#globalModal');
        });
    });

});


    $(document).on('click', '.changeStatus', function () {

        let id   = $(this).data('id');
        let type = $(this).data('type');

        let url = "{{ route('tenant.tasks.status', ':id') }}";
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
