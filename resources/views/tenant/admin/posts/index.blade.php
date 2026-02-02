@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
 @include('tenant.admin.projects.tabs',['id'=>$project->id])
   @include('tenant.includes.universal-modal')
       {{-- ADD BUTTON --}}
        @if(canAccess('create_posts'))
            <button id="addBtn" class="btn btn-primary mb-3">
                Add Post
            </button>

        @endif
           @include('tenant.includes.universal-pagination', [
            'url' => tenantRoute('posts.index',  null,['id'=>base64_encode($project->id)]),
            'wrapperId' => 'postsTable',
            'content' => view('tenant.admin.posts.table', [
            'posts' => $posts
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
                    name: "text",
                    description:'textarea',
                };
                let usersstore = "{{  tenantRoute('posts.store') }}";
                $("#universalForm").attr("action", usersstore);

                loadForm(fields, "Add Post");
                $('input[name="project_id"]').val(PROJECT_ID);

                addDocumentField('#modalBody');
                    $('#globalModal').off('shown.bs.modal').on('shown.bs.modal', function () {
                        initModalPlugins();
                    });


            });
        });



    </script>
@endpush
