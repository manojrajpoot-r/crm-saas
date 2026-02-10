@extends('tenant.layouts.tenant_master')

@section('content')

<div class="main-panel">
    <div class="content">


    <form id="universalForm" method="POST" action="{{ $item ? tenantRoute('settings.update', null, ['id' => $item->id]) : tenantRoute('settings.store') }}"
        enctype="multipart/form-data"
>


        @csrf
        <input type="hidden" name="redirect" value="{{ tenantRoute('settings.index') }}">
        <input type="hidden" name="id" value="{{ $item->id ?? '' }}">
        @include('tenant.includes.universal-form', [
            'fields' => $fields,
            'item' => $item
        ])


        <button type="submit" id="formSubmitBtn" class="btn btn-primary px-5">
        <span class="btn-text">  {{ isset($item->id) ? 'Update' : 'Create' }}</span>
        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
        </button>

    </form>

    </div>
</div>
@endsection

@push('scripts')
  @include('tenant.includes.universal-scripts')
@endpush
