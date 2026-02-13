@extends('tenant.layouts.tenant_master')

@section('content')

<div class="main-panel">
    <div class="content">


        <form id="universalForm" method="POST" action="{{ $item
            ? tenantRoute('employee.myreports.update', null, ['id' => base64_encode($item->id)])
            : tenantRoute('employee.myreports.store') }}"

            enctype="multipart/form-data">

            @csrf
            <input type="hidden" name="redirect" value="{{ tenantRoute('employee.myreports.index') }}">
            <input type="hidden" name="id" value="{{ $item->id ?? '' }}">
            <input type="hidden" name="report_date" value="{{ now()->toDateTimeString() }}">



            {{-- REPORT TYPE --}}
            <div class="card mb-4">
                <div class="card-body">

                        <label class="form-label fw-bold d-block">Report Type</label>

                        <div class="d-flex gap-4 mb-3">
                            <div class="form-check">
                                <input class="form-check-input reportType"
                                    type="radio"
                                    name="report_type"
                                    value="project">
                                <label class="form-check-label">With Project</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input reportType"
                                    type="radio"
                                    name="report_type"
                                    value="other">
                                <label class="form-check-label">Other</label>
                            </div>


                           <div>
                                <h5>Report date</h5>
                                <span>{{ now()->format('l, d M Y') }}</span>

                            </div>

                        </div>



                            {{-- MULTIPLE PROJECTS --}}
                            <div id="projectWrapper">
                                @php $i = 0; @endphp

                                @if($item && $item->projects && $item->projects->count())
                                    @foreach($item->projects as $p)
                                     @include('tenant.employee.myprofile.report.project-row', [
                                        'i' => $i,
                                        'p' => $p
                                    ])

                                        @php $i++; @endphp
                                    @endforeach
                                @else
                                    @include('tenant.employee.myprofile.report.project-row', ['i' => 0])
                                @endif
                            </div>




                        <button type="button"
                                class="btn btn-sm btn-outline-secondary addDoc mt-2">
                            ➕ Add Document
                        </button>



                        <div class="col-sm-4" id="addProjectWrapper">
                            <button type="button"
                                    id="addProject"
                                    class="btn btn-sm btn-outline-secondary mt-3">
                                ➕ Add Project
                            </button>
                        </div>

         <div class="mt-5 d-flex gap-3">

    {{-- SAVE AS DRAFT --}}
    <button type="submit"
            name="action"
            value="draft"

            class="btn btn-secondary px-5">
        Save as Draft
         <span class="spinner-border spinner-border-sm d-none" role="status"></span>
    </button>

    {{-- FINAL SUBMIT --}}
    <button type="submit"
            name="action"
            value="submit"
              id="formSubmitBtn"
            class="btn btn-primary px-5">

        Final Submit
          <span class="spinner-border spinner-border-sm d-none" role="status"></span>
    </button>

</div>


{{--
                        <div class="mt-5">
                                <button type="submit" id="formSubmitBtn" class="btn btn-primary px-5">
                                <span class="btn-text">  {{ isset($item->id) ? 'Update' : 'Create' }}</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                </button>
                        </div> --}}
                    </div>
             </div>
        </form>

    </div>
</div>
@endsection
@php
    $projectCount = ($item && $item->projects) ? $item->projects->count() : 1;

@endphp

@push('scripts')
  @include('tenant.includes.universal-scripts')
<script>


function toggleReportSection(value) {
    if (value === 'project') {
        document.getElementById('projectSection')?.classList.remove('d-none');
        document.getElementById('addProjectWrapper')?.classList.remove('d-none');

    } else {
        document.getElementById('projectSection')?.classList.add('d-none');
        document.getElementById('addProjectWrapper')?.classList.add('d-none');

    }
}


document.querySelectorAll('.reportType').forEach(radio => {
    radio.addEventListener('change', function () {
        toggleReportSection(this.value);
    });
});


document.addEventListener('DOMContentLoaded', function () {
    let checked = document.querySelector('.reportType:checked');
    if (checked) toggleReportSection(checked.value);
});








let index = {{ $projectCount }};


document.getElementById('addProject').addEventListener('click', () => {

    let html = `
    <div class="project-row border rounded p-3 mb-3 shadow-sm bg-white">
        <div class="row col-md-12">

            <div class="col-md-12">
                <label class="fw-semibold">Project</label>
                <select name="projects[${index}][project_id]" class="form-select project-select">
                    <option value="">Select Project</option>
                    @foreach($projects as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>


            <div class="col-md-12">
                <label class="fw-semibold">Work Description</label>
                <textarea name="projects[${index}][description]"
                          class="form-control summernote"
                          rows="8"></textarea>
            </div>

            <div class="col-md-2">
                <label class="fw-semibold">Hours</label>
                <input type="number"
                       step="0.25"
                       min="0"
                       name="projects[${index}][hours]"
                       class="form-control">
            </div>


            <div class="col-md-2 d-flex align-items-end">
                <button type="button"
                        class="btn btn-outline-danger removeProject w-100">
                    ✖ Remove
                </button>
            </div>

        </div>
    </div>`;

    let wrapper = document.getElementById('projectWrapper');
    wrapper.insertAdjacentHTML('beforeend', html);

    initSummernote(wrapper.lastElementChild);
    index++;
});



document.addEventListener('click', function (e) {
    if (e.target.classList.contains('removeProject')) {
        e.target.closest('.project-row').remove();
    }
});








document.addEventListener('click', function (e) {

    // ADD DOCUMENT
    if (e.target.classList.contains('addDoc')) {

        let wrapper = e.target.previousElementSibling;

        let html = `
        <div class="doc-row d-flex gap-2 mb-2">
            <input type="file"
                   name="documents[]"
                   class="form-control">

            <button type="button"
                    class="btn btn-danger removeDoc">
                ✖
            </button>
        </div>`;

        wrapper.insertAdjacentHTML('beforeend', html);

        wrapper.querySelectorAll('.removeDoc').forEach(btn => {
            btn.classList.remove('d-none');
        });
    }

    // REMOVE DOCUMENT
    if (e.target.classList.contains('removeDoc')) {
        let wrapper = e.target.closest('.document-wrapper');
        e.target.closest('.doc-row').remove();

        let rows = wrapper.querySelectorAll('.doc-row');
        if (rows.length === 1) {
            rows[0].querySelector('.removeDoc').classList.add('d-none');
        }
    }
});


</script>
@endpush

