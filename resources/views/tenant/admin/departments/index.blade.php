@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
   @include('tenant.includes.universal-modal')
       {{-- ADD BUTTON --}}
        @if(canAccess('create_departments'))
            <button id="addBtn" class="btn btn-primary mb-3">
                Add Department
            </button>

        @endif
           @include('tenant.includes.universal-pagination', [
            'url' => tenantRoute('departments.index'),
            'wrapperId' => 'departmentsTable',
            'content' => view('tenant.admin.departments.table', [
            'departments' => $departments,
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
            };
         let departmentstore = "{{ tenantRoute('departments.store') }}";
          $("#universalForm").attr("action", departmentstore);

            loadForm(fields, "Add Department");
        });
        });
    </script>
@endpush
