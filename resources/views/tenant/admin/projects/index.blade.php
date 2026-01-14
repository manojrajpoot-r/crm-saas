@extends('tenant.layouts.tenant_master')

@section('content')
<style>
     .select2-container { width: 100% !important; }
</style>
<div class="main-panel">
    <div class="content">

        @include('tenant.includes.universal-modal')
        @include('tenant.includes.universal-form')

        @if (canAccess('projects add'))
             <button id="addBtn" class="btn btn-primary mb-2">Add Project</button>
        @endif
        @include('tenant.includes.universal-datatable')
    </div>
</div>
<!-- Multi Select -->

@endsection

@push('scripts')
    @include('tenant.includes.universal-scripts')

    <script>

        $(document).ready(function () {

            let columns = [
                { data: 'DT_RowIndex', title: '#', orderable: false, searchable: false },
                { data: 'name', title: 'Project Name' },
                { data: 'created_by', title: 'Created At' },
                { data: 'dates',title: 'Date'},
                { data: 'dead_line', title: 'Dead Line' },
                { data: 'status_btn', title: 'Status', orderable: false, searchable: false },
                { data: 'action', title: 'Action', orderable: false, searchable: false }
            ];

           let listUrl = "{{ currentGuard() === 'saas'? route('saas.projects.list'): route('tenant.projects.list', ['tenant' => currentTenant()]) }}";

            loadDataTable(columns, listUrl);

            // =======================
            // ADD BUTTON
            // =======================
            $("#addBtn").click(function() {
                let userlist = "{{ currentGuard() === 'saas'? route('saas.users.list'): route('tenant.users.list', ['tenant' => currentTenant()]) }}";
                $.get(userlist, function(users) {
                let data = users.data;
                let userOptions = data.map(u => `${u.id}|${u.name}`).join(',');

                    let statusOptions = "created|Created,working|Working,on_hold|On Hold,finished|Finished,maintenance|Maintenance,delay|Delay,handover|Handover,discontinued|Discontinued,inactive|Inactive";
                    let typeOptions = "fixed|Fixed,product|Product";

                    let fields = {
                        type: "select:" + typeOptions,
                        name: "text",
                        description: "textarea",
                        start_date: "date",
                        end_date: "date",
                        actual_start_date: "date",
                        total_days: "number",
                        created_by: "select:" + userOptions,
                        user_id: "multiselect:" + userOptions,
                        client_id: "multiselect:" + userOptions,
                        status: "select:" + statusOptions,
                        remarks: "text",

                    };



                let usersstore = "{{ currentGuard() === 'saas'? route('saas.projects.store'): route('tenant.projects.store', ['tenant' => currentTenant()]) }}";
                $("#universalForm").attr("action", usersstore);
                loadForm(fields, "Add Project");
                  // summer note
                 initSummernote('#globalModal');
                // multiple files
                 addDocumentField();
                });
            });
        });







    </script>


@endpush

