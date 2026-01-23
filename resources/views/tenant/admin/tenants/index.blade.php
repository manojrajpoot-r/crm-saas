@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
   @include('tenant.includes.universal-modal')
       {{-- ADD BUTTON --}}
        @if(canAccess('create_tenants'))
            <button id="addBtn" class="btn btn-primary mb-3">
                Add Tenant
            </button>

        @endif
           @include('tenant.includes.universal-pagination', [
            'url' => tenantRoute('tenants.list'),
            'wrapperId' => 'tenantsTable',
            'content' => view('tenant.admin.tenants.table', [
                'tenants' => \App\Models\Tenant\Tenant::latest()->paginate(10)
            ])
        ])

    </div>
</div>
@endsection
@push('scripts')
    @include('tenant.includes.universal-scripts')
    <script>

        $("#addBtn").click(function() {
            let fields = {
                name: "text",
                domain: "text",
                email:'text',
                password:'password',
            };

            let tenantstore = "{{ route('saas.tenants.store') }}";
            $("#universalForm").attr("action", tenantstore);

             let hasTenantUser = {{ $hasTenantUser ? 'true' : 'false' }};
            loadForm(fields, "Add Tenant",hasTenantUser);

        });
    </script>
@endpush
