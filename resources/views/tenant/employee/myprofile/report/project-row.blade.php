@php
    $p = $p ?? null;
@endphp

<div class="project-row border rounded p-3 mb-3 shadow-sm bg-white">
    <div class="row">

        {{-- PROJECT SECTION --}}
        <div class="col-md-12 mb-3" id="projectSection">
            <label class="fw-semibold">Project</label>
            <select
                name="projects[{{ $i }}][project_id]"
                class="form-select project-select">
                <option value="">Select Project</option>
                @foreach($projects as $id => $name)
                    <option value="{{ $id }}"
                        {{ optional($p)->project_id == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- WORK DESCRIPTION --}}
        <div class="col-md-12 mb-3">
            <label class="fw-semibold">Work Description</label>
            <textarea
                name="projects[{{ $i }}][description]"
                class="form-control summernote"
                rows="8">{{ optional($p)->description }}</textarea>
        </div>

        {{-- HOURS --}}
        <div class="col-md-3 mb-3">
            <label class="fw-semibold">Hours</label>
            <input
                type="number"
                step="0.25"
                min="0"
                name="projects[{{ $i }}][hours]"
                value="{{ optional($p)->hours }}"
                class="form-control">
        </div>

        {{-- REMOVE BUTTON --}}
        <div class="col-md-3 mb-3 d-flex align-items-end">
            <button
                type="button"
                class="btn btn-outline-danger removeProject w-100">
                ✖ Remove
            </button>
        </div>

        {{-- ADMIN COMMENT --}}
        @if(Auth::user()->master==1)
            <div class="col-md-12 mt-2">
                <label class="fw-semibold">Admin Comment</label>
                <textarea
                    name="projects[{{ $i }}][admin_comment]"
                    class="form-control"
                    rows="2">{{ optional($p)->admin_comment }}</textarea>
            </div>
        @endif

    </div>
</div>
