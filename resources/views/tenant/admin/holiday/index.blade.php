@extends('tenant.layouts.tenant_master')

@section('content')

<div class="main-panel">
    <div class="content">
        @include('tenant.includes.universal-modal')

        @if(canAccess('create_users'))
            <button id="addBtn" class="btn btn-primary mb-3">
                Add Holiday
            </button>
        @endif

            @include('tenant.includes.universal-pagination', [
                    'url' => tenantRoute('holidays.index'),
                    'wrapperId' => 'holidayTable',
                    'content' => view('tenant.admin.holiday.table', [
                    'holidays' => $holidays
                    ])
                ])
            </table>
        </div>

    </div>
</div>
@endsection

@push('scripts')
    @include('tenant.includes.universal-scripts')
    <script>
       $(document).ready(function () {

    $("#addBtn").click(function() {
        $('#modalBody').html('');
            let fields = {
            title: "text",
            date: "date",
            type:  "select:national|National Holiday,festival|Festival Holiday,optional|Optional Holiday,company|Company Holiday,regional|Regional Holiday",
            is_optional: "checkbox",
            description: "textarea",

        };

        let holidaystore = "{{  tenantRoute('holidays.store') }}";
        $("#universalForm").attr("action", holidaystore);

        loadForm(fields, "Add Holiday");
           $('#globalModal').off('shown.bs.modal').on('shown.bs.modal', function () {
                        initModalPlugins();
                    });
    });
});
    </script>
@endpush

