@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
   @include('tenant.includes.universal-modal')
       {{-- ADD BUTTON --}}
        @if(canAccess('create_users'))
            <button id="addBtn" class="btn btn-primary mb-3">
                Add User
            </button>

        @endif
           @include('tenant.includes.universal-pagination', [
            'url' => tenantRoute('users.list'),
            'wrapperId' => 'usersTable',
            'content' => view('tenant.admin.tenant-users.table', [
                'users' => \App\Models\Tenant\TenantUser::with('role')->latest()->paginate(10)
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
                let ROLES = @json($roles);
                let roleOptions = ROLES.map(r => `${r.id}|${r.name}`).join(',');
                let fields = {
                    name: "text",
                    email: "text",
                    phone:"number",
                    password: "password",
                    profile: "file",
                    role_id: "select:" + roleOptions,

                };

                let usersstore = "{{ currentGuard() === 'saas'? route('saas.users.store'): tenantRoute('users.store', ['tenant' => currentTenant()]) }}";
                $("#universalForm").attr("action", usersstore);

                    loadForm(fields, "Add User");
                });
            });

    </script>
@endpush


