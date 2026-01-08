@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
        @include('tenant.includes.universal-modal')
        @include('tenant.includes.universal-form')

         @if (canAccess('assigns add'))
        <button id="addBtn" class="btn btn-primary mb-2">Add Assign</button>
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
                  { data: 'user_name',title:'User Name'},
                    { data: 'asset_name',title:'Asset Name'},
                    { data: 'assigned_date',title:'Assign date'},
                    { data: 'return_date',title:'Return Date'},
                { data: 'action', title: 'Action', orderable: false, searchable: false }
            ];


            let listUrl = "{{ currentGuard() === 'saas'? route('saas.assigns.list'): route('tenant.assigns.list') }}";
            loadDataTable(columns,listUrl);

        // =======================
        // ADD BUTTON
        // =======================
      $("#addBtn").click(function () {

        let userlist = "{{ currentGuard() === 'saas' ? route('saas.users.list'): route('tenant.users.list') }}";

        let assetlist = "{{ currentGuard() === 'saas' ? route('saas.asset_assigns.list'): route('tenant.asset_assigns.list') }}";

            $.when(
                $.get(userlist),
                $.get(assetlist)
            ).done(function (usersRes, assetsRes) {

                let users = usersRes[0].data;
                let assets = assetsRes[0].data;

                let userOptions = users.map(u => `${u.id}|${u.name}`).join(',');
                let assetOptions = assets.map(a => `${a.id}|${a.name}`).join(',');

                let fields = {
                    user_id: "select:" + userOptions,
                    asset_id: "select:" + assetOptions,
                };

                let storeUrl = "{{ currentGuard() === 'saas'? route('saas.assigns.store'): route('tenant.assigns.store') }}";

                $("#universalForm").attr("action", storeUrl);

                loadForm(fields, "Assign Asset");
            });
        });

    });
    </script>
@endpush

