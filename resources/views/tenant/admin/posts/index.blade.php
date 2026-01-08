@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
        @include('tenant.admin.projects.tabs',['id'=>$project->id])
        @include('tenant.includes.universal-modal')
        @include('tenant.includes.universal-form')

         @if (canAccess('post add'))
        <button id="addBtn" class="btn btn-primary mb-2 mt-3">Add Post</button>
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
                {data:'uploaded_by',title:'Uploaded By'},
                { data: 'name', title: 'Name'},
                { data: 'description', title: 'Description'},
                { data: 'status_btn', title: 'Status', orderable: false, searchable: false },
                { data: 'action', title: 'Action', orderable: false, searchable: false }
            ];


            let listUrl = "{{ currentGuard() === 'saas'? route('saas.posts.list'): route('tenant.posts.list') }}"+ "?project_id=" + PROJECT_ID;
            loadDataTable(columns,listUrl);

        // =======================
        // ADD BUTTON
        // =======================
        $("#addBtn").click(function() {
            let fields = {
                project_id: "hidden",
                name: "text",
                description:'textarea',

            };
         let usersstore = "{{ currentGuard() === 'saas'? route('saas.posts.store'): route('tenant.posts.store') }}";
          $("#universalForm").attr("action", usersstore);

            loadForm(fields, "Add Post");
               $('input[name="project_id"]').val(PROJECT_ID);
             // summer note
                initSummernote('#globalModal');

                 setTimeout(() => {
                $("#modalBody").append(`
                   <div id="docWrapper">
                        <div class="row mb-2">

                            <div class="col-md-5">
                                <input type="file" name="documents[]" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-success addDoc">+</button>
                            </div>
                        </div>
                    </div>
                `);
            }, 100);
        });
        });



    </script>
@endpush
