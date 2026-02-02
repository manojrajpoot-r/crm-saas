@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">

        @include('tenant.includes.universal-modal')

        @if(canAccess('create_roles'))
            <button id="addBtn" class="btn btn-primary mb-3">
                Add Role
            </button>
        @endif

        @include('tenant.includes.universal-pagination', [
            'url' => tenantRoute('roles.index', 'saas.roles.index'),
            'wrapperId' => 'rolesTable',
            'content' => view('tenant.admin.roles.table', [
            'roles' => $roles
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
                $('#modalBody').html('');

                let fields = {
                    name: "text"
                };
                let rolestore = "{{ currentGuard() === 'saas'? route('saas.roles.store'): tenantRoute('roles.store') }}";
                $("#universalForm").attr("action", rolestore);
                loadForm(fields, "Add Role");
            });

        });
    </script>
@endpush
