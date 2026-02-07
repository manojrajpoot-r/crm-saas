@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">

        @include('tenant.includes.universal-modal')

        @if(canAccess('create_settings'))
            <a id="addBtn" href ="{{tenantRoute('settings.create')}}" class="btn btn-primary mb-3">
                Add Setting
            </a>
        @endif

        @include('tenant.includes.universal-pagination', [
            'url' => tenantRoute('settings.index', 'saas.settings.index'),
            'wrapperId' => 'settingsTable',
            'content' => view('tenant.admin.settings.table', [
            'settings' => $settings
            ])
        ])

    </div>
</div>
@endsection

@push('scripts')
    @include('tenant.includes.universal-scripts')

@endpush
