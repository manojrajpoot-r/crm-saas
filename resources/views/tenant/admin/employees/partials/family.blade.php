<div class="card">
    <div class="card-header fw-bold">Family Information</div>

    <div class="card-body">
        <div class="row g-3">

            <div class="col-md-6">
                <label> Name</label>
                <input type="text" name="name"
                       value="{{ old('name', $employee?->familyInfos->first()?->name) }}"
                       class="form-control">
            </div>

            <div class="col-md-6">
                <label>Relation Name</label>
                <input type="text" name="relation"
                       value="{{ old('relation', $employee?->familyInfos->first()?->relation) }}"
                       class="form-control">
            </div>

            <div class="col-md-6">
                <label>Phone</label>
                <input type="text" name="phone"
                       value="{{ old('phone', $employee?->familyInfos->first()?->phone) }}"
                       class="form-control">
            </div>


        </div>
    </div>
</div>
