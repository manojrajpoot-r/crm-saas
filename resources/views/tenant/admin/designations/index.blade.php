@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
        @include('tenant.includes.universal-modal')
        @include('tenant.includes.universal-form')

         @if (canAccess('designations add'))
        <button id="addBtn" class="btn btn-primary mb-2">Add Designation</button>
        @endif
        @include('tenant.includes.universal-datatable')
    </div>
</div>


@endsection

@push('scripts')
    @include('tenant.includes.universal-scripts')

    <script>

        $(document).ready(function () {

            let fields = {
                name: "text",
                status: "select:Active,Inactive"
            };

            let columns = [
                { data: 'DT_RowIndex', title: '#', orderable: false, searchable: false },
                { data: 'name', title: 'Name' },
                { data: 'department_id', title: 'Department' },
                { data: 'status_btn', title: 'Status', orderable: false, searchable: false },
                { data: 'action', title: 'Action', orderable: false, searchable: false }
            ];


            let listUrl = "{{ currentGuard() === 'saas'? route('saas.designations.list'): route('tenant.designations.list') }}";
            loadDataTable(columns,listUrl);

        // =======================
        // ADD BUTTON
        // =======================
        $("#addBtn").click(function() {
             let departmentlist = "{{ currentGuard() === 'saas'? route('saas.departments.list'): route('tenant.departments.list', ['tenant' => currentTenant()]) }}";
                $.get(departmentlist, function(departments) {

                 let data = departments.data;

                let departmentOptions = data.map(d => `${d.id}|${d.name}`).join(',');
            let fields = {
                name: "text",
                department_id: "select:" + departmentOptions
            };
            let usersstore = "{{ currentGuard() === 'saas'? route('saas.designations.store'): route('tenant.designations.store') }}";
            $("#universalForm").attr("action", usersstore);

                loadForm(fields, "Add Designation");
            });
        });
    });
    </script>
@endpush
