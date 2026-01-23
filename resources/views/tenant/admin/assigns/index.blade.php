@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
   @include('tenant.includes.universal-modal')
       {{-- ADD BUTTON --}}
        @if(canAccess('create_users'))
            <button id="addBtn" class="btn btn-primary mb-3">
                Add Assignment
            </button>

        @endif
           @include('tenant.includes.universal-pagination', [
            'url' => tenantRoute('assigns.list'),
            'wrapperId' => 'assignsTable',
            'content' => view('tenant.admin.assigns.table', [
            'assignedAssets' => \App\Models\Tenant\AssignedAsset::latest()->paginate(10)
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
                const EMPLOYEES = @json($employees);
                const ASSETS    = @json($assets);

                let employeeOptions = EMPLOYEES.map(e => `${e.id}|${e.first_name} ${e.last_name}` ).join(',');

                let assetOptions = ASSETS.map(a => `${a.id}|${a.name}` ).join(',');

                let fields = {
                    employee_id: "select:" + employeeOptions,
                    asset_id: "select:" + assetOptions,
                };

                let storeUrl = "{{  tenantRoute('assigns.store') }}";

                $("#universalForm").attr("action", storeUrl);

                loadForm(fields, "Assign Asset");

        });

    });
    </script>
@endpush

