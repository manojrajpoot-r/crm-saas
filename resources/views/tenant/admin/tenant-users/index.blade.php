@extends('tenant.layouts.tenant_master')

@section('content')
@php
    $usersUrl = match (currentGuard()) {
        'saas'   => route('saas.import.users.index'),
        'tenant' => tenantRoute('import.users.index'),
        default  => '',
    };
@endphp

<div class="row g-2">
    <div class="col-md-4 col-sm-12">
        <input type="text" id="searchUser" class="form-control form-control-sm" placeholder="Search users...">
    </div>

   <div class="col-md-4 col-sm-12">
        <a href="{{$usersUrl}}" class="btn btn-primary">Import</a>
    </div>


</div>

<div class="main-panel">
    <div class="content">
        @include('tenant.includes.universal-modal')

        @if(canAccess('create_users'))
            <button id="addBtn" class="btn btn-primary mb-3">
                Add User
            </button>
        @endif

            @include('tenant.includes.universal-pagination', [
                    'url' => tenantRoute('users.index', 'saas.users.index'),
                    'wrapperId' => 'usersTable',
                    'content' => view('tenant.admin.tenant-users.table', [
                        'users' => $users
                    ])
                ])
            </table>
        </div>

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

        let usersstore = "{{ currentGuard() === 'saas' ? route('saas.users.store') : tenantRoute('users.store') }}";
        $("#universalForm").attr("action", usersstore);

        loadForm(fields, "Add User");
    });
});
    </script>
@endpush
