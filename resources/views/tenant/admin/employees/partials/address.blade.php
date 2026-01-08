{{-- ================= ADDRESS ================= --}}
<div class="card mb-4"> <div class="card-header fw-bold">Communication Address</div>
<div class="card-body"> <h6 class="text-success">Present Address</h6>
    <div class="row g-3 mb-4"> <div class="col-md-6">
         <textarea class="form-control" name="present_address" placeholder="Address">{{ old('present_address', $employee?->address?->present_address) }}</textarea> </div>
         <div class="col-md-6">
            <input class="form-control" name="present_landmark" placeholder="Landmark" value="{{ old('present_landmark', $employee?->address?->present_landmark) }}"> </div>
            <div class="col-md-4"> <input name="present_zipcode" id="present_zipcode" value="{{ old('present_zipcode', $employee?->address?->present_zipcode) }}" placeholder="Zip Code" class="form-control"> </div>
             <div class="col-md-4"> <input name="present_country" id="present_country" value="{{ old('present_country', $employee?->address?->present_country) }}" placeholder="Country" class="form-control"> </div>
             <div class="col-md-4"> <input name="present_state" id="present_state" value="{{ old('present_state', $employee?->address?->present_state) }}"placeholder="State" class="form-control"> </div>
             <div class="col-md-4"> <input name="present_city" id="present_city" value="{{ old('present_city', $employee?->address?->present_city) }}" placeholder="City" class="form-control"> </div> </div>
             <h6 class="text-primary">Permanent Address</h6> <div class="row g-3"> <div class="col-md-6"> <textarea class="form-control" name="permanent_address" placeholder="Address">{{ old('permanent_address', $employee?->address?->permanent_address) }}</textarea> </div>
              <div class="col-md-6"> <input class="form-control" name="permanent_landmark" placeholder="Landmark" value="{{ old('permanent_landmark', $employee?->address?->permanent_landmark) }}"> </div>
               <div class="col-md-4"> <input name="permanent_zipcode" id="permanent_zipcode" value="{{ old('permanent_zipcode', $employee?->address?->permanent_zipcode) }}" placeholder="Zip Code" class="form-control"> </div>
               <div class="col-md-4"> <input name="permanent_country" id="permanent_country" value="{{ old('permanent_country', $employee?->address?->permanent_country) }}" placeholder="Country" class="form-control"> </div>
               <div class="col-md-4"> <input name="permanent_state" id="permanent_state" value="{{ old('permanent_state', $employee?->address?->permanent_state) }}" placeholder="State" class="form-control"> </div>
               <div class="col-md-4"> <input name="permanent_city" id="permanent_city" value="{{ old('permanent_city', $employee?->address?->permanent_city) }}" placeholder="City" class="form-control"> </div> </div>
            </div>
        </div>
