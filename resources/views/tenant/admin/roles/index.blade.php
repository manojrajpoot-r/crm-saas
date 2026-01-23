@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
   @include('tenant.includes.universal-modal')
       {{-- ADD BUTTON --}}
        @if(canAccess('create_roles'))
            <button id="addBtn" class="btn btn-primary mb-3">
                Add Role
            </button>

        @endif
           @include('tenant.includes.universal-pagination', [
            'url' => tenantRoute('roles.list'),
            'wrapperId' => 'rolesTable',
            'content' => view('tenant.admin.roles.table', [
            'roles' => \App\Models\Tenant\Role::latest()->paginate(10)
            ])
        ])

    </div>
</div>
@endsection
@push('scripts')
    @include('tenant.includes.universal-scripts')
     <script>

        $(document).ready(function () {

            $("#addBtn").click(function() {

            $('#modalBody').html('');


                let fields = {
                    name: "text",

                };

                let rolestore = "{{ currentGuard() === 'saas'? route('saas.roles.store'): tenantRoute('roles.store') }}";
                $("#universalForm").attr("action", rolestore);

                    loadForm(fields, "Add Role");
                });
            });


    </script>
@endpush


