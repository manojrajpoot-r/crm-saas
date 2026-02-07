<div class="project-row border rounded p-3 mb-3 shadow-sm bg-white">
    <div class="row col-md-12">

{{-- PROJECT SECTION --}}
<div id="projectSection">

    {{-- Project --}}
    <div class="col-md-12 mb-3">
        <label class="fw-semibold">Project</label>
        <select name="projects[{{ $i }}][project_id]"
                class="form-select project-select">
            <option value="">Select Project</option>
            @foreach($projects as $id => $name)
                <option value="{{ $id }}"
                    {{ ($p->project_id ?? '') == $id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
    </div>

</div>





        {{-- Description (SUMMERNOTE) --}}
        <div class="col-md-12">
            <label class="fw-semibold">Work Description</label>
            <textarea
                name="projects[{{ $i }}][description]"
                class="form-control summernote" id="description"
                rows="3">{{ $p->description ?? '' }}</textarea>
        </div>

        {{-- Hours --}}
        <div class="col-md-2">
            <label class="fw-semibold">Hours</label>
            <input type="number"
                   step="0.25"
                   min="0"
                   name="projects[{{ $i }}][hours]"
                   value="{{ $p->hours ?? '' }}"
                   class="form-control">
        </div>


        {{-- Remove --}}
        <div class="col-md-2 d-flex align-items-end">
            <button type="button"
                    class="btn btn-outline-danger removeProject w-100">
                ✖ Remove
            </button>
        </div>

        {{-- Admin Comment --}}
        @if(currentGuard() === 'saas' || currentGuard() === 'admin')
            <div class="col-md-12">
                <label class="fw-semibold">Admin Comment</label>
                <textarea name="projects[{{ $i }}][admin_comment]"
                          class="form-control"
                          rows="2">{{ $p->admin_comment ?? '' }}</textarea>
            </div>
        @endif

    </div>
</div>
