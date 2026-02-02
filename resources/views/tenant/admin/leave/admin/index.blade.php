@extends('tenant.layouts.tenant_master')

@section('content')
<div class="row g-2">
    <div class="col-md-4 col-sm-12">
        <input type="text" id="searchUser" class="form-control form-control-sm"
               placeholder="Search employee...">
    </div>

    <div class="col-md-4 col-sm-12">
        <select id="filterMonth" class="form-select form-select-sm">
            <option value="">All Months</option>
            @for($m=1;$m<=12;$m++)
                <option value="{{ $m }}">{{ date('F', mktime(0,0,0,$m,1)) }}</option>
            @endfor
        </select>
    </div>

    <div class="col-md-4 col-sm-12">
        <select id="filterStatus" class="form-select form-select-sm">
            <option value="">All Status</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
        </select>
    </div>
</div>


<div class="main-panel">
    <div class="content">

        @include('tenant.includes.universal-modal')

            @if(canAccess('create_leaves'))
                <button id="addBtn" class="btn btn-primary mb-3">
                    Add Leaves
                </button>

            @endif
           @include('tenant.includes.universal-pagination', [
            'url' => tenantRoute('leaves.index',null,[]),
            'wrapperId' => 'leavesTable',
            'content' => view('tenant.admin.leave.admin.table', [
            'users' => $users,
            'userStats'=>$userStats,
            'leaveTypes' =>$leaveTypes
            ])
        ])

    </div>
</div>
@endsection

@push('scripts')
    @include('tenant.includes.universal-scripts')

    <script>
        $("#addBtn").click(function () {

            $("#universalForm")[0].reset();
            $("#modalBody").empty();

            let leaveTypes = @json($leaveTypes);
            let users = @json($userdropdwons);

            let leaveTypeOptions = leaveTypes.map(l => `${l.id}|${l.name}`).join(',');
            let userOptions = users.map(u => `${u.id}|${u.name}`).join(',');

            let fields = {
                apply_to: "select:" + userOptions,
                cc_to: "multiselect:" + userOptions,
                leave_type_id: "select:" + leaveTypeOptions,
                start_date: "date",
                end_date: "date",
                total_days: { type: "number", readonly: true },
                subject:"text",
                reason: "textarea",
            };

            let leavestore = "{{ tenantRoute('leaves.store') }}";
            $("#universalForm").attr("action", leavestore);

            loadForm(fields, "Apply Leave");

            $('#globalModal').off('shown.bs.modal').on('shown.bs.modal', function () {
                initModalPlugins();
            });
        });

    </script>
@endpush


