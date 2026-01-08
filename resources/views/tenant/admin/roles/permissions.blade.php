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
    outline: none;
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

.view-color { color: #007bff; font-weight: bold; }
.add-color { color: #28a745; font-weight: bold; }
.edit-color { color: #fd7e14; font-weight: bold; }
.delete-color { color: #dc3545; font-weight: bold; }

#searchBox { width: 300px; margin-bottom: 15px; }
.action-icon { font-size: 16px; margin-right: 4px; }


.main-panel [type="checkbox"]:not(:checked), [type="checkbox"]:checked{
    position: relative !important;
    left: 0 !important;

    top: 2px;


}
</style>

<div class="main-panel">
    <div class="container">

        <h3 class="mb-4">Manage Permissions ({{ $role->name }})</h3>

        <input type="text" id="searchBox" class="form-control" placeholder="Search permissions...">

        <button type="button" id="selectAll" class="btn btn-success btn-sm mt-2">Select All</button>
        <button type="button" id="unselectAll" class="btn btn-danger btn-sm mt-2">Unselect All</button>

         @php
            $action = match (currentGuard()) {
                'saas'   => route('saas.roles.permissions.update', $role->id),
                'tenant' => route('tenant.roles.permissions.update', ['tenant' => currentTenant(), 'id' => $role->id]),
                default  => '#',
            };
        @endphp

        <form id="universalForm" method="POST" action="{{ $action }}">

            @csrf

            <table class="table table-bordered" style="margin-top: 25px">
                <thead>
                    <tr>
                        <th>Module</th>
                        <th colspan="10">Permissions</th>
                        <th>Row Select</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($allPermissions as $moduleName => $permissions)
                        <tr>
                            <td>{{ $moduleName }}</td>

                            @foreach($permissions as $permission)
                                <td>
                                    <input type="checkbox"
                                        name="permission_ids[]"
                                        value="{{ $permission->id }}"
                                        {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                    {{ $permission->group }}
                                </td>
                            @endforeach

                            {{-- Empty cells if module has less than 4 permissions --}}
                            @for($i = count($permissions); $i < 4; $i++)
                                <td></td>
                            @endfor

                            <td>
                                <input type="checkbox" class="row-select">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


            <button type="submit" class="btn btn-primary mt-2">Save Permissions</button>
        </form>

    </div>
</div>

@push('scripts')
    @include('tenant.includes.universal-scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Row select toggle
    document.querySelectorAll('.row-select').forEach(cb => {
        cb.addEventListener('change', function() {
            const row = cb.closest('tr');
            row.querySelectorAll('.action-checkbox').forEach(ch => ch.checked = cb.checked);
        });
    });

    // Select All / Unselect All
    document.getElementById('selectAll').addEventListener('click', () => {
        document.querySelectorAll('.action-checkbox').forEach(ch => ch.checked = true);
        document.querySelectorAll('.row-select').forEach(ch => ch.checked = true);
    });
    document.getElementById('unselectAll').addEventListener('click', () => {
        document.querySelectorAll('.action-checkbox').forEach(ch => ch.checked = false);
        document.querySelectorAll('.row-select').forEach(ch => ch.checked = false);
    });

    // Search filter
    document.getElementById('searchBox').addEventListener('input', function() {
        const search = this.value.toLowerCase();
        document.querySelectorAll('#permissionsTable tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(search) ? '' : 'none';
        });
    });
});
</script>
@endpush
@endsection
