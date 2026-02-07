@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">



<form id="universalForm" method="POST" action="{{ tenantRoute('employee.change.password.update')}}" enctype="multipart/form-data">


        @csrf
        @include('tenant.includes.universal-form', [
            'fields' => $fields,

        ])


        <button type="submit" id="formSubmitBtn" class="btn btn-primary px-5">
        <span class="btn-text"> Change Password</span>
        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
        </button>

    </form>


    </div>
</div>
@endsection

@push('scripts')
    @include('tenant.includes.universal-scripts')

@endpush
