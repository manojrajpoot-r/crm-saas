@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">

        <div class="container" style="margin-top: 70px;margin-left:40px;">
                {{currentTenant() ? "Upload & Tenant Users" : "Upload & Saas Users"}}

            @if(currentTenant())
                <form id="universalForm"
                    action="{{ tenantRoute('import.upload') }}"
                    method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="import_type" value="tenant">
                    <div class="form-group">
                        <label>Select Tenant</label>
                        <select name="tenant" class="form-control">
                            <option value="">-- Select Tenant --</option>
                            @foreach($tenants as $t)
                                <option value="{{ $t->slug }}">{{ $t->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Select File</label>
                        <input type="file" name="file" id="" class="form-control" required>
                    </div>

                    <div class="form-group mt-2">
                        <label>Duplicate Handling</label>
                        <select name="duplicate_action" id="duplicateAction" class="form-control">
                            <option value="skip">Skip Duplicates</option>
                            <option value="update">Update Duplicates</option>
                            <option value="stop">Stop on Duplicate</option>
                        </select>
                    </div>

                    <button type="submit" id="formSubmitBtn" class="btn btn-primary mt-3">Start Import</button>
                </form>

                @else

                <form id="universalForm"
                    action="{{ route('saas.import.upload') }}"
                    method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Import Into</label>
                        <select name="import_type" id="importType" class="form-control">
                            <option value="saas">SaaS (Admin Users)</option>
                            <option value="tenant">Tenant Users</option>
                        </select>
                    </div>
                    <div class="form-group" id="tenantBox" style="display:none">
                        <label>Select Tenant</label>
                        <select name="tenant" class="form-control">
                            <option value="">-- Select Tenant --</option>
                            @foreach($tenants as $t)
                                <option value="{{ $t->slug }}">{{ $t->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Select File</label>
                        <input type="file" name="file" id="fileInput" class="form-control" required>
                    </div>

                    <div class="form-group mt-2">
                        <label>Duplicate Handling</label>
                        <select name="duplicate_action" id="duplicateAction" class="form-control">
                            <option value="skip">Skip Duplicates</option>
                            <option value="update">Update Duplicates</option>
                            <option value="stop">Stop on Duplicate</option>
                        </select>
                    </div>

                    <div id="mappingContainer" class="mt-3" style="display:none;">
                        <h5>Map Excel Columns to DB Fields</h5>
                        <div id="mappingFields"></div>
                    </div>

                    <button type="submit" id="formSubmitBtn" class="btn btn-primary mt-3">Start Import</button>
                </form>
            @endif

        </div>
    </div>
</div>
@endsection

@push('scripts')
    @include('tenant.includes.universal-scripts')
    <script>
    $('#importType').on('change', function(){
        if(this.value === 'tenant'){
            $('#tenantBox').show();
        } else {
            $('#tenantBox').hide();
        }
    });

    </script>

@endpush

