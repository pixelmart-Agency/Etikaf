<div class="col-md-{{ $col ?? 12 }} this-input-{{ $name }}"
    style="display: {{ isset($allObject->$ajax_model) && $allObject->$ajax_model == $allObject->$ajax_response_to ? 'none' : '' }}">
    <div class="md-3">
        <label for="{{ $name }}" class="form-label">@lang('translation.' . ucfirst($label))</label>
        <input type="{{ $type ?? 'text' }}" name="{{ $name }}" value="{{ $value ?? old($name) }}"
            class="form-control {{ $class ?? '' }}" id="{{ $name }}" placeholder="@lang('translation.' . ucfirst($label))">
        @error($name)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
