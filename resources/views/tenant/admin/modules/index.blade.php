


@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
    @include('tenant.admin.projects.tabs',['id'=>$project->id])
   @include('tenant.includes.universal-modal')
       {{-- ADD BUTTON --}}
        @if(canAccess('create_modules'))
            <button id="addBtn" class="btn btn-primary mb-3">
                Add Module
            </button>

        @endif
           @include('tenant.includes.universal-pagination', [
            'url' => tenantRoute('modules.list'),
            'wrapperId' => 'moduleTable',
            'content' => view('tenant.admin.modules.table', [
            'modules' => \App\Models\Tenant\ProjectModule::latest()->paginate(10)
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
                project_id: "hidden",
                title: "text",
                notes:"textarea",
                start_date:"date",
                end_date:"date",
            };
            let modulestore = "{{  tenantRoute('modules.store') }}";
          $("#universalForm").attr("action", modulestore);

            loadForm(fields, "Add Module");
             $('input[name="project_id"]').val(PROJECT_ID);
                $('#globalModal').off('shown.bs.modal').on('shown.bs.modal', function () {
                    initModalPlugins();
            });
        });
        });
    </script>
@endpush

