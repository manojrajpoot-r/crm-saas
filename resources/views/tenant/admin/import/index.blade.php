@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
        @include('tenant.includes.universal-datatable')
    </div>
</div>


@endsection

@push('scripts')
    @include('tenant.includes.universal-scripts')

    <script>
  $(document).ready(function () {

                    let columns = [
                        { data: 'DT_RowIndex', title: '#', orderable: false, searchable: false },
                        {data:  'file',title:'File'},
                        { data: 'total_rows', title: 'Total Row'},
                        { data: 'processed_rows', title: 'Processed Rows'},
                        {data:  'progress',title:'Progress'},
                        { data: 'created_at',title:'Created At'},
                        { data: 'status_btn', title: 'Status', orderable: false, searchable: false },
                        { data: 'action', title: 'Action', orderable: false, searchable: false }
                    ];


                    let listUrl = "{{ route('saas.imports.list')}}";
                    loadDataTable(columns,listUrl);

        });

    </script>
@endpush
