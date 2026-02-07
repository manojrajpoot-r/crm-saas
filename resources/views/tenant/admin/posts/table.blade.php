<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Uploaded By</th>
            <th>Description</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody id="tableBody">
        @forelse($posts as $key => $t)
        <tr>
            <td>{{ $posts->firstItem() + $key }}</td>

            {{-- UPLOADED BY --}}
            <td>
                @php
                    $profile = $t->uploader && $t->uploader->profile
                        ? asset('uploads/tenantusers/profile/'.$t->uploader->profile)
                        : asset('images/default-profile.png');

                    $name = $t->uploader->name ?? 'Unknown';
                @endphp

                <div class="d-flex align-items-center gap-2">
                    <img src="{{ $profile }}" width="35" height="35"
                         style="border-radius:50%;object-fit:cover">
                    <span>{{ $name }}</span>
                </div>
            </td>

            {{-- DESCRIPTION --}}
            <td>
                @php
                    $desc = strip_tags($t->description ?? '');
                    $short = strlen($desc) > 100 ? substr($desc,0,100).'...' : $desc;
                @endphp

                <div class="fw-semibold">{{ $short }}</div>
                <small class="text-muted">
                    Created: {{ ($t->created_at) }}
                </small>

                <div class="mt-1">
                    <button class="btn btn-sm btn-primary universalViewDetails"
                        data-url="{{ tenantRoute('posts.show',null,$t->id) }}">
                        View
                    </button>
                </div>
            </td>

            {{-- STATUS --}}
            <td>
                @if(!canAccess('status_discussion'))
                    <span class="badge bg-secondary">No Access</span>
                @else
                    <button
                        class="btn btn-sm {{ $t->status ? 'btn-success':'btn-danger' }} statusBtn"
                        data-url="{{ tenantRoute('posts.status',null,$t->id) }}">
                        {{ $t->status ? 'Active':'Inactive' }}
                    </button>
                @endif
            </td>

            {{-- ACTION --}}
            <td>
                @if(canAccess('edit_discussion'))
                    <button class="btn btn-info btn-sm editBtn"
                        data-url="{{ tenantRoute('posts.edit',null,$t->id) }}">
                        Edit
                    </button>
                @endif

                @if(canAccess('delete_discussion'))
                    <button class="btn btn-danger btn-sm deleteBtn"
                        data-url="{{ tenantRoute('posts.delete',null,$t->id) }}">
                        Delete
                    </button>
                @endif

                @if(canAccess('create_comments'))
                    @php
                        $comments = \App\Models\Tenant\Comment::where('project_id',$t->project_id)->count();
                    @endphp

                    <button class="btn btn-secondary btn-sm dynamicGlobalModal"
                        data-title="Comment Posts"
                        data-id="{{ $t->project_id }}"
                        data-user_id="{{ auth()->id() }}"
                        data-url="{{ tenantRoute('comments.store') }}">
                        Comment
                    </button>

                    <a href="{{ tenantRoute('comments.index',null,['id'=>base64_encode($t->project_id)]) }}"
                        class="btn btn-sm btn-outline-primary">
                        View Comments ({{ $comments }})
                    </a>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">No Posts Found</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-3">
    {{ $posts->links('pagination::bootstrap-5') }}
</div>
