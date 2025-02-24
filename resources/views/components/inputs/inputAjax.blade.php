@php
    if (!empty($single)) {
        $selectData = getDataByModel($input['model'], [$parent_id => $single->$parent_id]);
    } else {
        $selectData = [];
    }
@endphp
<div class="col-md-{{ $col ?? 12 }}">
    <div class="md-3">
        <label for="{{ rtrim($name, '[]') }}" class="form-label">@lang('translation.' . ucfirst($label))</label>
        <select class="form-control {{ $class }}" name="{{ $name }}" {{ $attrs ?? '' }}
            id="{{ rtrim($name, '[]') }}">
            <option value="">{{ $optionLable ?? __('translation.Choose') }}</option>
            @foreach ($selectData as $iter)
                <option value="{{ $iter->id }}"
                    {{ isset($value) && ($value == $iter->id || (is_array($value) && in_array($iter->id, $value))) ? 'selected' : '' }}>
                    {{ getTransValue($iter->name ?? $iter->morphData->name) }}</option>
            @endforeach
        </select>
        @error($name)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
