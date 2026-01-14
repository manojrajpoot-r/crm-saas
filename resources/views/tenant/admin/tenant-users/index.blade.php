@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
        @include('tenant.includes.universal-modal')
        @include('tenant.includes.universal-form')

        @if (canAccess('users add'))
             <button id="addBtn" class="btn btn-primary mb-2">Add User</button>
        @endif
        <div class="text-center">
            @if (canAccess('users import'))
                    <a href="{{route('saas.import.users.index')}}"  class="btn btn-primary mb-2">Import</a>
                @endif
        </div>
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
                {data: 'profile_img', title: 'Profile', orderable: false, searchable: false },
                { data: 'name', title: 'Name' },
                { data: 'email', title: 'Email' },
                 { data: 'role_id', title: 'Role' },
                { data: 'status_btn', title: 'Status', orderable: false, searchable: false },
                { data: 'action', title: 'Action', orderable: false, searchable: false }
            ];

           let listUrl = "{{ currentGuard() === 'saas'? route('saas.users.list'): route('tenant.users.list', ['tenant' => currentTenant()]) }}";

            loadDataTable(columns, listUrl);

            // =======================
            // ADD BUTTON
            // =======================
            $("#addBtn").click(function() {


                $("#universalForm")[0].reset();
                $("#profilePreview").html("");
                $(".profile-preview").remove();

                let rolelist = "{{ currentGuard() === 'saas'? route('saas.roles.list'): route('tenant.roles.list', ['tenant' => currentTenant()]) }}";
                $.get(rolelist, function(roles) {

                 let data = roles.data;

                let roleOptions = data.map(r => `${r.id}|${r.name}`).join(',');

                let fields = {
                    name: "text",
                    email: "text",
                    password: "password",
                    profile: "file",
                    role_id: "select:" + roleOptions,

                };

                let usersstore = "{{ currentGuard() === 'saas'? route('saas.users.store'): route('tenant.users.store', ['tenant' => currentTenant()]) }}";
                $("#universalForm").attr("action", usersstore);

                    loadForm(fields, "Add User");



                });
            });
        });
    </script>
@endpush
