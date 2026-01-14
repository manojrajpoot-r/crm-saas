@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
          @include('tenant.admin.projects.tabs',['id'=>$project->id])
        @include('tenant.includes.universal-modal')
        @include('tenant.includes.universal-form')

         @if (canAccess('roles add'))
        <button id="addBtn" class="btn btn-primary mb-2 mt-3">Add Module</button>
        @endif
        @include('tenant.includes.universal-datatable')
    </div>
</div>


@endsection

@push('scripts')
    @include('tenant.includes.universal-scripts')

    <script>

        $(document).ready(function () {

             let PROJECT_ID = "{{ $project->id }}";

            let columns = [
                { data: 'DT_RowIndex', title: '#', orderable: false, searchable: false },
                { data: 'title', title: 'Name' },
                 { data: 'start_date', title: 'Start Date' },
                { data: 'end_date', title: 'End Date' },
                { data: 'created_at', title: 'Created At' },
                { data: 'status_btn', title: 'Status', orderable: false, searchable: false },
                { data: 'action', title: 'Action', orderable: false, searchable: false }
            ];


          let listUrl = "{{ route('tenant.modules.list') }}"+ "?project_id=" + PROJECT_ID;
            loadDataTable(columns,listUrl);

        // =======================
        // ADD BUTTON
        // =======================
        $("#addBtn").click(function() {
            let fields = {
                project_id: "hidden",
                title: "text",
                notes:"textarea",
                start_date:"date",
                end_date:"date",

            };
         let usersstore = "{{ currentGuard() === 'saas'? route('saas.modules.store'): route('tenant.modules.store', ['tenant' => currentTenant()]) }}";
          $("#universalForm").attr("action", usersstore);

            loadForm(fields, "Add Module");
             $('input[name="project_id"]').val(PROJECT_ID);
        });
        });
    </script>
@endpush

