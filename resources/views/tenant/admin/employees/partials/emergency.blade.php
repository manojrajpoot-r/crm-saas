<div class="card">
    <div class="card-header fw-bold">Emergency Contact</div>

    <div class="card-body">
        <div class="row g-3">

            <div class="col-md-6">
                <label>Contact Name</label>
                <input type="text" name="name"
                      value="{{ old('name', $employee?->emergencyContacts?->first()?->name) }}"
                       class="form-control">
            </div>

            <div class="col-md-6">
                <label>Relation</label>
                <input type="text" name="relation"
                       value="{{ old('relation', $employee?->emergencyContacts?->first()?->relation ?? '') }}"
                       class="form-control">
            </div>

            <div class="col-md-6">
                <label>Phone</label>
                <input type="text" name="phone"
                       value="{{ old('phone', $employee?->emergencyContacts?->first()?->phone ?? '') }}"
                       class="form-control">
            </div>

            <div class="col-md-6">
                <label>Address</label>
                <textarea name="address"
                          class="form-control">{{ old('address', $employee?->emergencyContacts?->first()?->address ?? '') }}</textarea>
            </div>

        </div>
    </div>
</div>
