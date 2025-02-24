@foreach (appLangs() as $lang)
    <div class="col-md-{{ $col ?? 12 }}">
        <div class="md-3">
            <label for="{{ $name . '_' . $lang }}" class="form-label {{ $class ?? '' }}">@lang('translation.' . ucfirst($label))
                @lang('translation. in ' . $lang)</label>
            <input type="{{ $type ?? 'text' }}" name="{{ $name . '_' . $lang }}"
                value="{{ old($name . $lang, getSetting($name . '_' . $lang)) }}" class="form-control"
                id="{{ $name . '_' . $lang }}" placeholder="@lang('translation.' . ucfirst($label)) @lang('translation. in ' . $lang)">
            @error($name . $lang)
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
@endforeach
