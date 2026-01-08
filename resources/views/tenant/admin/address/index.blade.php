@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
        @include('tenant.includes.universal-modal')
        @include('tenant.includes.universal-form')

         {{-- @if (canAccess('employeeAddress add'))
        <button id="addBtn" class="btn btn-primary mb-2">Add EmployeeAddress</button>
        @endif --}}
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

                { data: 'employee_name', title: 'Employee Name' },

                { data: 'present_address_full', title: 'Present Address' },
                { data: 'permanent_address_full', title: 'Permanent Address' },

                // { data: 'status_btn', title: 'Status', orderable: false, searchable: false },
                // { data: 'action', title: 'Action', orderable: false, searchable: false }
            ];




            let listUrl = "{{ currentGuard() === 'saas'? route('saas.employeeAddress.list'): route('tenant.employeeAddress.list') }}";
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
            let usersstore = "{{ currentGuard() === 'saas'? route('saas.employeeAddress.store'): route('tenant.employeeAddress.store') }}";
            $("#universalForm").attr("action", usersstore);

                loadForm(fields, "Add EmployeeAddress");
            });
        });
    });
    </script>
@endpush
