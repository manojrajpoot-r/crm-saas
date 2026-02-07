@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">

   @include('tenant.includes.universal-modal')


           @include('tenant.includes.universal-pagination', [
            'url' => tenantRoute('mytasks.index',null,[]),
            'wrapperId' => 'mytasksTable',
            'content' => view('tenant.admin.mytask.table', [
            'mytasks' => $mytasks,
            ])
        ])

    </div>
</div>
@endsection

@push('scripts')
    @include('tenant.includes.universal-scripts')


@endpush

