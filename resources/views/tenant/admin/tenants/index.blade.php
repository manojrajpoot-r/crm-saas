@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
        @include('tenant.includes.universal-modal')
        @include('tenant.includes.universal-form')

    @if (canAccess('tenants add'))
        <button id="addBtn" class="btn btn-primary mb-2">Add Tenant</button>
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
                { data: 'name', title: 'Name' },
                { data: 'domain', title: 'Domain' },
                { data: 'status_btn', title: 'Status', orderable: false, searchable: false },
                { data: 'action', title: 'Action', orderable: false, searchable: false }
            ];

             let listUrl = "{{ currentGuard() === 'saas'? route('saas.tenants.list'): route('tenant.tenants.list') }}";
            loadDataTable(columns,listUrl);

        // =======================
        // ADD BUTTON
        // =======================
        $("#addBtn").click(function() {
            let fields = {
                name: "text",
                domain: "text"
            };

            let usersstore = "{{ currentGuard() === 'saas'? route('saas.tenants.store'): route('tenant.tenants.store') }}";
            $("#universalForm").attr("action", usersstore);
            loadForm(fields, "Add Tenant");
        });
        });
    </script>
@endpush
