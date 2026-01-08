@extends('tenant.layouts.tenant_master')

@section('content')
<div class="main-panel">
    <div class="content ml-5">


                {{-- ====== TAB HEADERS ====== --}}
                <ul class="nav nav-tabs mb-3" id="employeeTabs">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#personal">
                            Personal Info
                        </button>
                    </li>


                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#address">
                            Address
                        </button>
                    </li>

                @if(isset($employee->id))
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#personal_identity_info">
                            Personal & Identity
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#emergency">
                            Emergency
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#family">
                            Family
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#bank">
                            Bank & UPI
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#education">
                            Education
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#experience">
                            Experience
                        </button>
                    </li>
                @endif
                </ul>


            <form id="universalForm" method="POST" action="{{ route('tenant.employees.store') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $employee->id ?? '' }}">

                {{-- ====== TAB CONTENT ====== --}}
                <div class="tab-content">

                    <div class="tab-pane fade show active" id="personal">
                        @include('tenant.admin.employees.partials.personal')
                    </div>


                    <div class="tab-pane fade" id="address">
                        @include('tenant.admin.employees.partials.address')
                    </div>

                @if(isset($employee->id))

                    <div class="tab-pane fade" id="personal_identity_info">
                        @include('tenant.admin.employees.partials.personal_identity_info')
                    </div>

                    <div class="tab-pane fade" id="emergency">
                        @include('tenant.admin.employees.partials.emergency')
                    </div>

                    <div class="tab-pane fade" id="family">
                        @include('tenant.admin.employees.partials.family')
                    </div>

                    <div class="tab-pane fade" id="bank">
                        @include('tenant.admin.employees.partials.bank_upi')
                    </div>

                    <div class="tab-pane fade" id="education">
                        @include('tenant.admin.employees.partials.education')
                    </div>

                    <div class="tab-pane fade" id="experience">
                        @include('tenant.admin.employees.partials.experience')
                    </div>

                    </div>
                 @endif
                {{-- ====== SUBMIT BUTTON ====== --}}


                   <div class="text-center mt-4 {{ isset($employee->id) ? '' : 'd-none' }}" id="submitBtnWrapper">
                    <button type="submit" class="btn btn-primary px-5">
                        {{ isset($employee->id) ? 'Update Employee' : 'Create Employee' }}
                    </button>
                </div>

            </form>

    </div>
</div>


@endsection
@push('scripts')


<script>
document.addEventListener('DOMContentLoaded', function () {

    const submitBtn = document.getElementById('submitBtnWrapper');
    const isEdit = {{ isset($employee->id) ? 'true' : 'false' }};

    // 🔥 Edit mode → button hamesha visible
    if (isEdit) {
        submitBtn?.classList.remove('d-none');
        return;
    }

    // 🔥 Add mode → sirf Address tab par dikhe
    function toggleButton(target) {
        if (target === '#address') {
            submitBtn?.classList.remove('d-none');
        } else {
            submitBtn?.classList.add('d-none');
        }
    }

    const activeTab = document.querySelector('.nav-link.active');
    if (activeTab) {
        toggleButton(activeTab.getAttribute('data-bs-target'));
    }

    document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function (e) {
            toggleButton(e.target.getAttribute('data-bs-target'));
        });
    });
});




</script>

    @include('tenant.includes.universal-scripts')
@endpush
