@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
   @include('tenant.includes.universal-modal')
       {{-- ADD BUTTON --}}
        @if(canAccess('create_users'))
            <button id="addBtn" class="btn btn-primary mb-3">
                Add Designation
            </button>

        @endif
           @include('tenant.includes.universal-pagination', [
            'url' => tenantRoute('designations.index'),
            'wrapperId' => 'designationsTable',
            'content' => view('tenant.admin.designations.table', [
            'designations' => $designations,
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
                let DEPARTMENTS  = @json($departmentList);
                let departmentOptions = DEPARTMENTS.map(d => `${d.id}|${d.name}`).join(',');

            let fields = {
                name: "text",
                department_id: "select:" + departmentOptions
            };
            let usersstore = "{{ tenantRoute('designations.store') }}";
            $("#universalForm").attr("action", usersstore);

                loadForm(fields, "Add Designation");
            });
        });

    </script>
@endpush
