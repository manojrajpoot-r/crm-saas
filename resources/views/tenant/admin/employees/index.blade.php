@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
   @include('tenant.includes.universal-modal')
       {{-- ADD BUTTON --}}
        @if(canAccess('create_employees'))
            <a id="addBtn" href="{{ tenantRoute('employees.edit')}}" class="btn btn-primary mb-3">
                Add Employee
            </a>

        @endif
           @include('tenant.includes.universal-pagination', [
            'url' => tenantRoute('employees.index'),
            'wrapperId' => 'employeesTable',
            'content' => view('tenant.admin.employees.table', [
            'employees' => $employees,
            ])
        ])

    </div>
</div>
@endsection
@push('scripts')
    @include('tenant.includes.universal-scripts')
@endpush

