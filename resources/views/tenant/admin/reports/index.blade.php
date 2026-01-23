@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content">
        @include('tenant.includes.universal-modal')
        @include('tenant.includes.universal-form')


       <div class="d-flex gap-2 mb-3">
            <select id="filterType" class="form-select w-auto">
                <option value="">Select Report</option>
                <option value="daily">Daily</option>
                <option value="weekly">Weekly</option>
                <option value="monthly">Monthly</option>
            </select>

            <input type="date" id="from_date" class="form-control d-inline w-auto">
            <input type="date" id="to_date" class="form-control d-inline w-auto">

            <button id="filterBtn" class="btn btn-primary">Filter</button>
            <button id="exportBtn" class="btn btn-dark">Export Excel</button>

       </div>

        @include('tenant.includes.universal-datatable')
    </div>
</div>


@endsection

@push('scripts')
    @include('tenant.includes.universal-scripts')

<script>


let table;

$(document).ready(function () {

    let columns = [
        { data: 'DT_RowIndex',title: '#', orderable: false, searchable: false },
        { data: 'employee_name',title: 'Employee Name' },
        { data: 'department_name',title: 'Department Name' },
        { data: 'designation_name',title: 'Designation Name' },
        { data: 'created_at',title: 'Date' },

    ];

    table = $('#universalTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ tenantRoute('reports.list') }}",
            data: function (d) {
                d.filter_type = $('#filterType').val();
                d.from_date   = $('#from_date').val();
                d.to_date     = $('#to_date').val();
            }
        },
        columns: columns
    });

    $('#filterType, #filterBtn').on('change click', function () {
        table.ajax.reload();
    });

    $('#exportBtn').on('click', function () {
        let params = $.param({
            filter_type: $('#filterType').val(),
            from_date: $('#from_date').val(),
            to_date: $('#to_date').val()
        });

        window.location.href = "{{ tenantRoute('reports.export') }}?" + params;
    });

});


</script>





@endpush
