
 <input type="hidden" name="id" value="{{ $address->employee_id  ?? '' }}">
    <div class="modal-body">


    {{--  PRESENT ADDRESS --}}
    <h6 class="mb-3 text-primary">Present Address</h6>

    <div class="mb-3">
        <label>Address</label>
        <textarea name="present_address" class="form-control" rows="3">
        {{ $address->present_address ?? '' }}</textarea>
    </div>

    <div class="mb-3">
        <label>Landmark</label>
        <input type="text" name="present_landmark"
               class="form-control"
               value="{{ $address->present_landmark ?? '' }}">
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label>City</label>
            <input type="text" name="present_city"
                   class="form-control"
                   value="{{ $address->present_city ?? '' }}">
        </div>

        <div class="col-md-4 mb-3">
            <label>State</label>
            <input type="text" name="present_state"
                   class="form-control"
                   value="{{ $address->present_state ?? '' }}">
        </div>

        <div class="col-md-4 mb-3">
            <label>Country</label>
            <input type="text" name="present_country"
                   class="form-control"
                   value="{{ $address->present_country ?? '' }}">
        </div>

        <div class="col-md-4 mb-3">
            <label>Zipcode</label>
            <input type="text" name="present_zipcode"
                   class="form-control"
                   value="{{ $address->present_zipcode ?? '' }}">
        </div>
    </div>

    <hr>

    {{--  PERMANENT ADDRESS --}}
        <div class="form-check mb-3">
        <input type="checkbox" class="form-check-input" id="sameAddress">
        <label class="form-check-label" for="sameAddress">
           <h5 style="color:springgreen"> Permanent address same as present</h5>
        </label>
    </div>

    <h6 class="mb-3 text-primary">Permanent Address</h6>

    <div class="mb-3">
        <label>Address</label>
        <textarea name="permanent_address" class="form-control" rows="3">
        {{ $address->permanent_address ?? '' }}</textarea>
    </div>

    <div class="mb-3">
        <label>Landmark</label>
        <input type="text" name="permanent_landmark"
               class="form-control"
               value="{{ $address->permanent_landmark ?? '' }}">
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label>City</label>
            <input type="text" name="permanent_city"
                   class="form-control"
                   value="{{ $address->permanent_city ?? '' }}">
        </div>

        <div class="col-md-4 mb-3">
            <label>State</label>
            <input type="text" name="permanent_state"
                   class="form-control"
                   value="{{ $address->permanent_state ?? '' }}">
        </div>

        <div class="col-md-4 mb-3">
            <label>Country</label>
            <input type="text" name="permanent_country"
                   class="form-control"
                   value="{{ $address->permanent_country ?? '' }}">
        </div>

        <div class="col-md-4 mb-3">
            <label>Zipcode</label>
            <input type="text" name="permanent_zipcode"
                   class="form-control"
                   value="{{ $address->permanent_zipcode ?? '' }}">
        </div>
    </div>







