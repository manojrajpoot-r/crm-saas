@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">

        @include('tenant.includes.universal-modal')

        @if(canAccess('create_myreport'))
            <a id="addBtn" href ="{{tenantRoute('employee.myreports.create')}}" class="btn btn-primary mb-3">
                Add Report
            </a>
        @endif

        @include('tenant.includes.universal-pagination', [
            'url' => tenantRoute('employee.myreports.index'),
            'wrapperId' => 'reportsTable',
            'content' => view('tenant.employee.myprofile.report.table', [
            'reports' => $reports
            ])
        ])

    </div>
</div>
@endsection

@push('scripts')
    @include('tenant.includes.universal-scripts')

@endpush
