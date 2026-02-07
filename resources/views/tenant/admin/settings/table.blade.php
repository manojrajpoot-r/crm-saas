<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
           <th>Company</th>
            <th>Email</th>
            <th>Timezone</th>
            <th>Currency</th>
            <th>Leave Auto</th>
            <th>Status</th>
            <th>Action</th>

        </tr>
    </thead>

    <tbody id="tableBody">
        @foreach($settings as $key => $s)
        <tr>
            <td>{{ $settings->firstItem() + $key }}</td>



          <td>{{ $s->company_name }}</td>

            <td>{{ $s->company_email }}</td>

            <td>{{ $s->timezone }}</td>

            <td>{{ $s->currency }}</td>

            <td>
                <span class="badge {{ $s->leave_auto_approve ? 'bg-success':'bg-secondary' }}">
                    {{ $s->leave_auto_approve ? 'Yes':'No' }}
                </span>
            </td>

             <td>
                    @if(canAccess('status_settings'))
                        <button
                            class="btn btn-sm {{ $s->status ? 'btn-success':'btn-danger' }} statusBtn"
                            data-url="{{ tenantRoute(
                                'settings.status',
                                'saas.settings.status',
                                ['id' => $s->id]
                            ) }}">
                            {{ $s->status ? 'Active':'Inactive' }}
                        </button>
                    @else
                        <span class="badge bg-secondary">No Access</span>
                    @endif
                </td>
            <td>
            @if(canAccess('edit_settings'))
                <a class="btn btn-sm btn-primary"
                    href="{{ tenantRoute('settings.edit', null,['id'=>base64_encode($s->id)]) }}">
                    Edit
                </a>
              @endif
           @if(canAccess('delete_settings'))
                <button
                    class="btn btn-danger btn-sm deleteBtn"
                    data-url="{{ tenantRoute('settings.delete','saas.settings.delete',['id' => $s->id]) }}">
                    Delete
                </button>
            @endif

            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-3">
    {{ $settings->links('pagination::bootstrap-5') }}
</div>
