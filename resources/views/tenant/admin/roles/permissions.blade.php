@extends('tenant.layouts.tenant_master')

@section('content')
<style>
.permission-switch {
    width: 45px;
    height: 22px;
    appearance: none;
    background: #ddd;
    border-radius: 20px;
    position: relative;
    cursor: pointer;
    transition: .3s;
}
.permission-switch:checked {
    background: #7a5a39;
}
.permission-switch:before {
    content: "";
    width: 18px;
    height: 18px;
    background: #fff;
    border-radius: 50%;
    position: absolute;
    top: 2px;
    left: 2px;
    transition: .3s;
}
.permission-switch:checked:before {
    left: 25px;
}

#searchBox {
    width: 300px;
    margin-bottom: 15px;
}

.main-panel [type="checkbox"]:not(:checked), [type="checkbox"]:checked{
    position: relative !important;
    left: 0 !important;
    top: 2px;
}
</style>

<div class="main-panel">
    <div class="container">

        <h3 class="mb-2">Manage Permissions ({{ $role->name }})</h3>
        <hr>

        <input type="text" id="searchBox" class="form-control" placeholder="Search permissions...">

        <div class="mt-2">
            <button type="button" id="selectAll" class="btn btn-success btn-sm">Select All</button>
            <button type="button" id="unselectAll" class="btn btn-danger btn-sm">Unselect All</button>
        </div>

        <hr>

        @php
            $action = match (currentGuard()) {
                'saas'   => route('saas.roles.permissions.update', $role->id),
                'tenant' => tenantRoute('roles.permissions.update', ['id' => $role->id]),
                default  => '#',
            };
        @endphp

        <form id="universalForm" method="POST" action="{{ $action }}">
            @csrf

            <table class="table table-bordered mt-3" id="permissionsTable">
                <thead class="table-light">
                    <tr>
                        <th width="200">Module</th>
                        <th colspan="6">Permissions</th>
                        <th width="120">Row Select</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($allPermissions as $moduleName => $permissions)
                        <tr>
                            <td><strong>{{ strtoupper($moduleName) }}</strong></td>

                            @foreach($permissions as $permission)
                                <td>
                                    <label class="d-flex align-items-center gap-1">
                                        <input type="checkbox"
                                            class="action-checkbox"
                                            name="permission_ids[]"
                                            value="{{ $permission->id }}"
                                            {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                        {{ $permission->name }}
                                    </label>
                                </td>
                            @endforeach

                            @for($i = count($permissions); $i < 10; $i++)
                                <td></td>
                            @endfor

                            <td class="text-center">
                                <input type="checkbox" class="row-select">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <hr>
            <button type="submit" id="formSubmitBtn" class="btn btn-primary">
                <span class="btn-text">Save Permissions</span>
                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
            </button>



        </form>

    </div>
</div>

@push('scripts')
@include('tenant.includes.universal-scripts')
<script>

document.addEventListener('DOMContentLoaded', function () {

    // Row select
    document.querySelectorAll('.row-select').forEach(rowCheckbox => {
        rowCheckbox.addEventListener('change', function () {
            const row = this.closest('tr');
            row.querySelectorAll('.action-checkbox')
                .forEach(cb => cb.checked = this.checked);
        });
    });

    // Select all
    document.getElementById('selectAll').addEventListener('click', () => {
        document.querySelectorAll('.action-checkbox, .row-select')
            .forEach(cb => cb.checked = true);
    });

    // Unselect all
    document.getElementById('unselectAll').addEventListener('click', () => {
        document.querySelectorAll('.action-checkbox, .row-select')
            .forEach(cb => cb.checked = false);
    });

    // Search filter
    document.getElementById('searchBox').addEventListener('keyup', function () {
        const value = this.value.toLowerCase();
        document.querySelectorAll('#permissionsTable tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(value)
                ? ''
                : 'none';
        });
    });

});
</script>
@endpush

@endsection
