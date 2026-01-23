@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
   @include('tenant.includes.universal-modal')
       {{-- ADD BUTTON --}}
        @if(canAccess('create_users'))
            <button id="addBtn" class="btn btn-primary mb-3">
                Add Project
            </button>

        @endif
           @include('tenant.includes.universal-pagination', [
            'url' => tenantRoute('projects.list'),
            'wrapperId' => 'projectsTable',
            'content' => view('tenant.admin.projects.table', [
            'projects' => \App\Models\Tenant\Project::latest()->paginate(10)
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

                $("#universalForm")[0].reset();
                $("#modalBody").empty();

                let storeUrl = "{{ tenantRoute('projects.store') }}";

                $("#universalForm").attr("action", storeUrl);

                 const EMPLOYEES = @json($employees);
                   let employeeOptions = EMPLOYEES.map(a => `${a.id}|${a.first_name} ${a.last_name}` ).join(',');

                    let fields = {
                        type: "select:fixed|Fixed,product|Product,hourly|Hourly,other|Other,service|Service,maintenance|Maintenance",
                        name: "text",
                        description: "textarea",
                        start_date: "date",
                        end_date: "date",
                        total_days: { type: "number", readonly: true },
                        status: "select:created|Created,working|Working,completed|Completed,on_hold|On Hold,cancelled|Cancelled,pending|Pending,closed|Closed,resolved|Resolved,reopened|Reopened,in_progress|In Progress",
                        employee_id: "multiselect:" + employeeOptions,
                        client_id: "multiselect:" + employeeOptions,
                        remarks: "text"
                    };

                    loadForm(fields, "Add Project");
                       addDocumentField('#modalBody');

                    $('#globalModal').off('shown.bs.modal').on('shown.bs.modal', function () {
                        initModalPlugins();
                    });
                });
            });



    </script>

@endpush

