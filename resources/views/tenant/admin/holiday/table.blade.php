<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Holiday</th>
            <th>Holiday Date</th>
            <th>Type</th>
            <th>Optional</th>
             <th>Description</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody id="tableBody">
        @foreach($holidays as $key => $h)
        <tr>
            <td>{{ $holidays->firstItem() + $key }}</td>
            <td>{{ $h->title }}</td>
            <td>{!! date_with_day_html($h->date) !!}</td>
            <td>{{ ucfirst($h->type) }}</td>

            <td>
                <span class="badge bg-{{ $h->is_optional ? 'warning' : 'success' }}">
                    {{ $h->is_optional ? 'Optional' : 'Mandatory' }}
                </span>
            </td>

            <td>
                <span
                    class="text-primary cursor-pointer view-description"
                    data-title="{{ $h->title }}"
                    data-description="{!! $h->description !!}"
                    title="View Description"
                >
                    {{$h->description ? '👁️' : '—'}}
                </span>
            </td>

              <td>
                    @if(canAccess('holiday_status'))
                        <button
                            class="btn btn-sm {{ $h->status ? 'btn-success':'btn-danger' }} statusBtn"
                            data-url="{{ tenantRoute('holidays.status',null,['id' => $h->id]) }}">
                            {{ $h->status ? 'Active':'Inactive' }}
                        </button>
                    @else
                        <span class="badge bg-secondary">No Access</span>
                    @endif
                </td>

            <td>
                @if(canAccess('holiday_edit') || ('holiday_delete'))
                    <button class="btn btn-info btn-sm editBtn"
                        data-url="{{ tenantRoute('holidays.edit',null,$h->id) }}">Edit</button>

                    <button class="btn btn-danger btn-sm deleteBtn"
                        data-url="{{ tenantRoute('holidays.delete',null,$h->id) }}">Delete</button>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-3">
    {{ $holidays->links('pagination::bootstrap-5') }}
</div>
