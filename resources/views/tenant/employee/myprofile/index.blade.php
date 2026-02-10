@extends('tenant.layouts.tenant_master')

@section('content')

@include('tenant.includes.universal-modal')
        <div class="row col-md-12">
            <div class="col-md-6">
                @include('tenant.employee.myprofile.partials.profile-header')
            </div>
             <div class="col-md-6">
                @include('tenant.employee.myprofile.partials.personal')
             </div>


          <div class="col-md-6">
                @include('tenant.employee.myprofile.partials.bank')
          </div>
        <div class="col-md-6">
                @include('tenant.employee.myprofile.partials.upi_info')
        </div>

            <div class="col-md-6">
                @include('tenant.employee.myprofile.partials.family')
            </div>
              <div class="col-md-6">
                  @include('tenant.employee.myprofile.partials.emergency')
            </div>


             <div class="col-md-6">
                @include('tenant.employee.myprofile.partials.education')
             </div>
               <div class="col-md-6">
                @include('tenant.employee.myprofile.partials.experience')
            </div>



            <div class="col-md-6">
                @include('tenant.employee.myprofile.partials.personal_details')
            </div>
            <div class="col-md-6">
                @include('tenant.employee.myprofile.partials.address')
            </div>
        </div>

@endsection

@push('scripts')
    @include('tenant.includes.universal-scripts')
@endpush

