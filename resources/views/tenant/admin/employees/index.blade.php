@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
   @include('tenant.includes.universal-modal')
       {{-- ADD BUTTON --}}
        @if(canAccess('create_employees'))
            <a href="{{ tenantRoute('employees.edit')}}" class="btn btn-primary mb-3">
                Add Employee
            </a>

        @endif
           @include('tenant.includes.universal-pagination', [
            'url' => tenantRoute('employees.list'),
            'wrapperId' => 'employeesTable',
            'content' => view('tenant.admin.employees.table', [
            'employees' => \App\Models\Tenant\Employee::latest()->paginate(10)
            ])
        ])

    </div>
</div>
@endsection
@push('scripts')
    @include('tenant.includes.universal-scripts')
@endpush

