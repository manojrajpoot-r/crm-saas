@extends('tenant.layouts.tenant_master')


@section('content')
<div class="main-panel">
    <div class="content">
 @include('tenant.admin.projects.tabs',['id'=>$project->id])
   @include('tenant.includes.universal-modal')

           @include('tenant.includes.universal-pagination', [
            'url' => tenantRoute('comments.index', null, ['id' => base64_encode($project->id)]),
            'wrapperId' => 'commentsTable',
            'content' => view('tenant.admin.comments.table', [
            'comments' => $comments,
            ])
        ])

    </div>
</div>
@endsection

@push('scripts')
    @include('tenant.includes.universal-scripts')
    </script>
@endpush
