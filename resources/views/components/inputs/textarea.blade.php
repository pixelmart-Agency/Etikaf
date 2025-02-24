@foreach (appLangs() as $lang)
    <div class="col-md-{{ $col ?? 12 }}">
        <div class="md-3">
            <label for="{{ $name . '_' . $lang }}" class="form-label">@lang('translation.' . ucfirst($label))
                @lang('translation. in ' . $lang)</label>
            <textarea name="{{ $name }}[{{ $lang }}]" class="form-control {{ $class ?? '' }}"
                id="{{ $name . '_' . $lang }}" placeholder="@lang('translation.' . ucfirst($label)) @lang('translation. in ' . $lang)">{{ getTransValue($value, $lang) ?? old($name . '.' . $lang) }}</textarea>
            @error($name . '.' . $lang)
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
@endforeach
