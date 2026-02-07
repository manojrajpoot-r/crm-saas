@props([
    'fields' => [],
    'item' => null
])

@foreach($fields as $section => $sectionFields)

    <div class="card mb-4">
        <div class="card-header">
            <strong>{{ $section }}</strong>
        </div>

        <div class="card-body">
            <div class="row">

                @foreach($sectionFields as $field)

                    {{-- Permission check --}}
                    @if(isset($field['permission']) && !canAccess($field['permission']))
                        @continue
                    @endif

                    @php
                        $name  = $field['name'];
                        $value = old($name, $field['value'] ?? null);
                        $type  = $field['type'];


                        $col = in_array($type, ['radio']) ? 'col-md-12' : 'col-md-6';


                    @endphp

                   <div class="{{ $col }} mb-3">

                        {{-- LABEL --}}
                      @if(!in_array($type, ['toggle','radio']))
                            <label class="form-label">
                                {{ $field['label'] ?? ucfirst($name) }}
                                @if($field['required'] ?? false)
                                    <span class="text-danger">*</span>
                                @endif
                            </label>
                        @endif






                        {{-- INPUT --}}
                        @if($type === 'input')
                            <input
                                type="{{ $field['type_attr'] ?? 'text' }}"
                                name="{{ $name }}"
                                value="{{ $value }}"
                                class="form-control"
                                {{ ($field['required'] ?? false) ? 'required' : '' }}>

                            {{-- REDIO --}}
                              @elseif($type === 'radio')

                                <label class="form-label d-block fw-bold mb-2">
                                    {{ $field['label'] }}
                                </label>

                                <div class="d-flex gap-4 align-items-center">

                                    @foreach($field['options'] as $key => $label)
                                        <div class="form-check">
                                            <input
                                                class="form-check-input reportType"
                                                type="radio"
                                                name="{{ $name }}"
                                                value="{{ $key }}"
                                                {{ $value == $key ? 'checked' : '' }}
                                            >
                                            <label class="form-check-label">
                                                {{ $label }}
                                            </label>
                                        </div>
                                    @endforeach

                                </div>



                        {{-- select --}}
                        @elseif($type === 'select')
                        <select name="{{ $name }}" class="form-select">
                            <option value="">-- Select --</option>

                            @foreach($field['options'] ?? [] as $key => $label)
                                <option value="{{ $key }}"
                                    {{ $value == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach


                        </select>



                        {{-- TEXTAREA --}}
                        @elseif($type === 'textarea')
                            <textarea
                                name="{{ $name }}"
                                rows="{{ $field['rows'] ?? 3 }}"
                                class="form-control"
                            >{{ $value }}</textarea>

                        {{-- DATE --}}
                        @elseif($type === 'date')
                            <input
                                type="date"
                                name="{{ $name }}"
                                value="{{ $value }}"
                                class="form-control"
                            >

                        {{-- FILE --}}
                  @elseif($type === 'file')

                    <div class="dropzone-wrapper">
                        <div class="dropzone file-dropzone">
                            <p class="mb-1">
                                Drag & drop files here or <strong>click</strong>
                            </p>
                            <small class="text-muted">Images only</small>

                            <input
                                type="file"
                                name="{{ $name }}{{ ($field['multiple'] ?? false) ? '[]' : '' }}"
                                class="file-input"
                                {{ ($field['multiple'] ?? false) ? 'multiple' : '' }}
                                hidden
                            >
                        </div>

                        <div class="preview-box d-flex gap-2 flex-wrap mt-2">

                            {{-- EDIT MODE EXISTING --}}
                            @if(($field['preview'] ?? false) && !empty($field['value']))
                                @php
                                    $values = is_array($field['value']) ? $field['value'] : [$field['value']];
                                @endphp

                                @foreach($values as $img)
                                    <img
                                        src="{{ asset(($field['preview_path'] ?? '').'/'.$img) }}"
                                        class="preview-img"
                                    >
                                @endforeach
                            @endif

                        </div>
                    </div>







                        {{-- TOGGLE --}}
                        @elseif($type === 'toggle')
                            <div class="form-check form-switch mt-4">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="{{ $name }}"
                                    value="1"
                                    {{ $value ? 'checked' : '' }}
                                >
                                <label class="form-check-label">
                                    {{ $field['label'] ?? ucfirst($name) }}
                                </label>
                            </div>
                        @endif

                        {{-- ERROR --}}
                        @error($name)
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                    </div>

                @endforeach

            </div>
        </div>
    </div>

@endforeach
