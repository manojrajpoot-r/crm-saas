@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">

   @include('tenant.includes.universal-modal')

        @if(canAccess('create_leave_types'))
            <button id="addBtn" class="btn btn-primary mb-3">
                Add Leave Type
            </button>

        @endif
           @include('tenant.includes.universal-pagination', [
            'url' => tenantRoute('leaveTypes.index',null,[]),
            'wrapperId' => 'leaveTypesTable',
            'content' => view('tenant.admin.leaveType.table', [
            'leaveTypes' => $leaveTypes,
            ])
        ])

    </div>
</div>
@endsection

@push('scripts')
    @include('tenant.includes.universal-scripts')

    <script>


        $(document).ready(function () {
        $("#addBtn").click(function() {
             $("#universalForm")[0].reset();
                $("#modalBody").empty();
                let fields = {
                    name: "text",
                    code: "text",
                    color: "color",
                    max_days: "number",
                    is_paid: "checkbox",
                    allow_half: "checkbox",
                    allow_short: "checkbox"
                };

            let leaveTypestore = "{{  tenantRoute('leaveTypes.store') }}";
          $("#universalForm").attr("action", leaveTypestore);

            loadForm(fields, "Add Leave Types");


        });
        });
    </script>
@endpush

