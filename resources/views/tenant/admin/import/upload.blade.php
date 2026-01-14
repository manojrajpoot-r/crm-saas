@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">

        <div class="container">
            <h2>Upload & Map Users</h2>

            <form id="universalForm"
                action="{{ route('saas.import.upload') }}"
                method="POST"
                enctype="multipart/form-data">
                @csrf

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
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @include('tenant.includes.universal-scripts')
    <script>

    </script>

@endpush

