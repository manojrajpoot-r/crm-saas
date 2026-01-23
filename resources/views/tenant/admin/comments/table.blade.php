<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Uploaded By</th>
            <th>Comment</th>
            <th>Documents</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse($comments as $key => $comment)
        <tr>
            <td>{{ $comments->firstItem() + $key }}</td>

            {{-- UPLOADED BY --}}
            <td class="text-uppercase">
                {{ $comment->user->name ?? '-' }}
            </td>

            {{-- COMMENT --}}
            <td>
                @php
                    $desc = strip_tags($comment->comment ?? '');
                    $short = strlen($desc) > 100 ? substr($desc,0,100).'...' : $desc;
                @endphp

                <div class="fw-semibold">{{ $short }}</div>
                <small class="text-muted">
                    Created: {{ ($comment->created_at) }}
                </small>

                <div class="mt-1">
                    <button class="btn btn-sm btn-primary universalViewDetails"
                        data-url="{{ route('tenant.comments.show',$comment->id) }}">
                        View
                    </button>
                </div>
            </td>

            {{-- DOCUMENTS --}}
            <td>
                @if($comment->documents->isEmpty())
                    -
                @else
                    @foreach($comment->documents as $doc)
                        <a href="{{ asset('uploads/comments/documents/'.$doc->file_path) }}"
                           target="_blank">
                            <i class="fa fa-file"></i>
                        </a>
                    @endforeach
                @endif
            </td>

            {{-- STATUS --}}
            <td>
                @if(!canAccess('status_comments'))
                    <span class="badge bg-secondary">No Access</span>
                @else
                    <button
                        class="btn btn-sm {{ $comment->status ? 'btn-success':'btn-danger' }} statusBtn"
                        data-url="{{ route('tenant.comments.status',$comment->id) }}">
                        {{ $comment->status ? 'Active':'Inactive' }}
                    </button>
                @endif
            </td>

            {{-- ACTION --}}
            <td>
                @if(canAccess('edit_comments'))
                    <button class="btn btn-info btn-sm editBtn"
                        data-url="{{ route('tenant.comments.edit',$comment->id) }}">
                        Edit
                    </button>
                @endif

                @if(canAccess('delete_comments'))
                    <button class="btn btn-danger btn-sm deleteBtn"
                        data-url="{{ route('tenant.comments.delete',$comment->id) }}">
                        Delete
                    </button>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">No Comments Found</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-3">
    {{ $comments->links('pagination::bootstrap-5') }}
</div>
