@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
   @include('tenant.includes.universal-modal')
       {{-- ADD BUTTON --}}
        @if(canAccess('create_permissions'))
            <button id="addBtn" class="btn btn-primary mb-3">
                Add Permission
            </button>

        @endif
           @include('tenant.includes.universal-pagination', [
            'url' => tenantRoute('permissions.index', 'saas.permissions.index'),
            'wrapperId' => 'permissionsTable',
            'content' => view('tenant.admin.permissions.table', [
            'permissions' => $permissions,
            ])
        ])

    </div>
</div>
@endsection
@push('scripts')
    @include('tenant.includes.universal-scripts')
    <script>


           $("#addBtn").click(function () {
            let fields = {
                group: "text",
            };
            let permissonstore = "{{ currentGuard() === 'saas' ? route('saas.permissions.store'): tenantRoute('permissions.store')}}";

            $("#universalForm").attr("action", permissonstore);
            loadForm(fields, "Add Permission");

            setTimeout(() => {
                $("#modalBody").append(`
                    <div class="form-group mt-3">
                        <label>Permission Name</label>
                        <div id="wrap"></div>
                    </div>
                `);

                $("#wrap").html(field('name', 'Enter role Name', true));
            }, 100);
        });



    </script>
@endpush
