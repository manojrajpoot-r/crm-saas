@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
        @include('tenant.includes.universal-modal')
        @include('tenant.includes.universal-form')

        @if (canAccess('roles add'))
            <button id="addBtn" class="btn btn-primary mb-2">Add Permission</button>
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
                  { data: 'group', title: 'Group' },
                { data: 'status_btn', title: 'Status', orderable: false, searchable: false },
                { data: 'action', title: 'Action', orderable: false, searchable: false }
            ];

             let listUrl = "{{ currentGuard() === 'saas'? route('saas.permissions.list'): route('tenant.permissions.list', ['tenant' => currentTenant()]) }}";
            loadDataTable(columns,listUrl);

            // =======================
            // ADD BUTTON
            // =======================
        $("#addBtn").click(function() {
            let fields = {
                name: "text",
            };

            let usersstore = "{{ currentGuard() === 'saas'? route('saas.permissions.store'): route('tenant.permissions.store', ['tenant' => currentTenant()]) }}";
            $("#universalForm").attr("action", usersstore);

            loadForm(fields, "Add Permission");

            setTimeout(() => {
                $("#modalBody").append(`
                    <div class="form-group mt-3">
                        <label>Permission Groups</label>

                        <div id="groupWrapper">
                            <div class="input-group mb-2 group-item">
                                <input type="text" name="group[]" class="form-control" placeholder="Enter group">
                                <button type="button" class="btn btn-success add-group"><i class="la la-plus"></i></button>
                            </div>
                        </div>
                    </div>
                `);
            }, 100);
        });
 });
    </script>
@endpush
