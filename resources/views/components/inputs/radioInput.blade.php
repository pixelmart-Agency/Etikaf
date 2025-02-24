@php
    $enum = 'App\\Enums\\' . $radioData;
@endphp

<div class="col-md-{{ $col ?? 12 }}">
    <div class="{{ $class ?? 'mt-3' }}">

        <div class="d-flex flex-column">
            @foreach ($enum::cases() as $case)
                <div class="custom-radio-container mb-3"
                    onclick="document.getElementById('{{ $name . '_' . $case->name }}').click()">
                    <input type="radio" class="custom-radio {{ $name }}" name="{{ $name }}"
                        id="{{ $name . '_' . $case->name }}" value="{{ !empty($case->value) ? $case->value : 0 }}"
                        {{ $case->value == $value ? 'checked' : '' }} onclick="toggleInput(this, {{ $ajax_model }})">
                    <label for="{{ $name . '_' . $case->name }}" class="custom-radio-label">
                        @lang('translation.' . ucfirst($label)) : {{ __('translation.' . $case->name) }}
                    </label>
                </div>
            @endforeach
        </div>

        @error($name)
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>

<input type="hidden" class="show-on" value="{{ $ajax_response_to }}">
