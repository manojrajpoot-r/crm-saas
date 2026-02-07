<input type="hidden" name="id" value="{{ $family->employee_id  ?? '' }}">
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name"
               class="form-control"
               value="{{ $family->name ?? '' }}">
    </div>

    <div class="mb-3">
        <label>Relation</label>
        <input type="text" name="relation"
               class="form-control"
               value="{{ $family->relation ?? '' }}">
    </div>

    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phone"
               class="form-control"
               value="{{ $family->phone ?? '' }}">
    </div>

