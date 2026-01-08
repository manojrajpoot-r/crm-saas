@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
        @include('tenant.includes.universal-modal')
        @include('tenant.includes.universal-form')

         @if (canAccess('employees add'))
        <a href="{{route('tenant.employees.edit')}}" class="btn btn-primary mb-2">Add Employee</a>
        @endif
        @include('tenant.includes.universal-datatable')
    </div>
</div>


@endsection

@push('scripts')
    @include('tenant.includes.universal-scripts')

    <script>

        $(document).ready(function () {


           let columns = [
            { data: 'DT_RowIndex', title: '#', orderable: false, searchable: false },
            { data: 'user_name', title: 'User Name' },
            { data: 'employee_id', title: 'Employee Code' },
            { data: 'first_name', title: 'First Name' },
            { data: 'last_name', title: 'Last Name' },
            { data: 'phone', title: 'Phone' },
            { data: 'emergency_phone', title: 'Emergency Phone' },
            { data: 'dob', title: 'Dob' },
            { data: 'gender', title: 'Gender' },
            { data: 'personal_email', title: 'Personal Email' },
            { data: 'corporate_email', title: 'Corporate Email' },
            { data: 'department_name', title: 'Department' },
            { data: 'designation_name', title: 'Designation' },
            { data: 'manager_name', title: 'Report To' },
            { data: 'join_date', title: 'Join Date' },
            { data: 'status_btn', title: 'Status', orderable: false, searchable: false },
            { data: 'action', title: 'Action', orderable: false, searchable: false }
        ];


            let listUrl = "{{ currentGuard() === 'saas'? route('saas.employees.list'): route('tenant.employees.list') }}";
            loadDataTable(columns,listUrl);


    });
    </script>
@endpush
