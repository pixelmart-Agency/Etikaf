    <div class="col-md-{{ $col ?? 12 }}">
        <div class="md-3">
            <label for="{{ $name }}" class="form-label {{ $class ?? '' }}">@lang('translation.' . ucfirst($label))
            </label>
            <input type="{{ $type ?? 'text' }}" name="{{ $name }}" value="{{ old($name, getSetting($name)) }}"
                class="form-control" id="{{ $name }}" placeholder="@lang('translation.' . ucfirst($label)) ">
            @error($name)
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
