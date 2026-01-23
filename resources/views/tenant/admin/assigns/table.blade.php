<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Employee</th>
            <th>Asset</th>
            <th>Assigned Date</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($assignedAssets as $key => $t)
        <tr>
            <td>{{ $assignedAssets->firstItem() + $key }}</td>

                <td>{{ $t->employee_name }}</td>
            <td>{{ $t->asset_name }}</td>

            <td>
                @if($t->is_assigned)
                    <button class="btn btn-sm btn-danger statusBtn"
                        data-url="{{ tenantRoute('assigns.status', $t->id) }}">
                        Return
                    </button>
                @else
                    -
                @endif
            </td>


            {{-- ASSIGNED DATE --}}
            <td>{{ $t->assigned_date }}</td>

            {{-- ACTION --}}
            <td>
                @if($t->status == 1)
                    <button
                        class="btn btn-sm btn-danger statusBtn"
                        data-url="{{ tenantRoute('assigns.status', $t->id) }}">
                        Return
                    </button>
                @else
                    -
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-3">
    {{ $assignedAssets->links('pagination::bootstrap-5') }}
</div>
