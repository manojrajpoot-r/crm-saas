<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Created By</th>
            <th>Dates</th>
            <th>Deadline</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($projects as $key => $t)
        <tr>
            <td>{{ $projects->firstItem() + $key }}</td>

            {{-- CREATED BY --}}
            <td>
             <img src="{{ $t->creator_profile }}" alt="profile" class="rounded-circle" width="30" height="30">
             {{ $t->creator_name }}


            </td>

            {{-- DATES --}}
            <td>
                {{ $t->dates_column }}
            </td>

            {{-- DEADLINE --}}
            <td>
                {{ $t->end_date ? $t->end_date->format('d M Y') : '-' }}
            </td>

            {{-- STATUS --}}
            <td>
                @if(canAccess('status_projects'))
                    @php
                        $label = ucwords(str_replace('_',' ',$t->status));
                    @endphp

                    <span class="badge bg-info me-2">{{ $label }}</span>

                    <a href="javascript:void(0)"
                       class="text-primary openStatusModal"
                       data-url="{{ tenantRoute('projects.status',$t->id) }}"
                       data-current="{{ $t->status }}"
                       title="Change Status">
                        <i class="fa fa-edit"></i>
                    </a>
                @else
                    <span class="badge bg-secondary">No Access</span>
                @endif
            </td>

            {{-- ACTION --}}
            <td>
                @if(canAccess('edit_projects'))
                    <button class="btn btn-info btn-sm editBtn"
                        data-url="{{ tenantRoute('projects.edit',$t->id) }}">
                        Edit
                    </button>
                @endif

                @if(canAccess('delete_projects'))
                    <button class="btn btn-danger btn-sm deleteBtn"
                        data-url="{{ tenantRoute('projects.delete',$t->id) }}">
                        Delete
                    </button>
                @endif

                @if(canAccess('details_view_projects'))
                    <a class="btn btn-primary btn-sm"
                       href="{{ tenantRoute('projects.show', base64_encode($t->id)) }}">
                        View
                    </a>
                @endif

                @if(
                    !canAccess('edit_projects')
                    && !canAccess('delete_projects')
                    && !canAccess('details_view_projects')
                )
                    No Action
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-3">
    {{ $projects->links('pagination::bootstrap-5') }}
</div>
