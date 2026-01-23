@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">

   @include('tenant.includes.universal-modal')
       {{-- ADD BUTTON --}}
        @if(canAccess('create_leaves'))
            <button id="addBtn" class="btn btn-primary mb-3">
                Add Leaves
            </button>

        @endif
           @include('tenant.includes.universal-pagination', [
            'url' => tenantRoute('leaves.list'),
            'wrapperId' => 'leavesTable',
            'content' => view('tenant.admin.leave.table', [
            'leaves' => \App\Models\Tenant\Leave::latest()->paginate(10)
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
                let leaveTypes = @json($leaveTypes);
                let users = @json($users);
                let leaveTypeOptions = leaveTypes.map(l => `${l.id}|${l.name}`).join(',');
                let usersOptions = users.map(u => `${u.id}|${u.name}`).join(',');

            let fields = {
                    user_id: "select:"+ usersOptions,
                    leave_type_id: "select:"+ leaveTypeOptions,
                    start_date: "date",
                    end_date: "date",
                    total_days: { type: "number", readonly: true },
                    reason: "textarea",
            };
            let leavestore = "{{  tenantRoute('leaves.store') }}";
          $("#universalForm").attr("action", leavestore);

            loadForm(fields, "Add Leave");

                $('#globalModal').off('shown.bs.modal').on('shown.bs.modal', function () {
                    initModalPlugins();
            });
        });
        });
    </script>
@endpush

