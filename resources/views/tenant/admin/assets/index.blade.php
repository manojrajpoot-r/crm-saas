@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
   @include('tenant.includes.universal-modal')
       {{-- ADD BUTTON --}}
        @if(canAccess('create_users'))
            <button id="addBtn" class="btn btn-primary mb-3">
                Add Asset
            </button>

        @endif
           @include('tenant.includes.universal-pagination', [
            'url' => tenantRoute('asset_assigns.index',null,[]),
            'wrapperId' => 'assetsTable',
            'content' => view('tenant.admin.assets.table', [
            'assets' => $assets,
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
                code: "text",
                type: "text",
            };
         let assetsstore = "{{ tenantRoute('asset_assigns.store') }}";
          $("#universalForm").attr("action", assetsstore);

            loadForm(fields, "Add Asset");
        });
    });

    </script>
@endpush

