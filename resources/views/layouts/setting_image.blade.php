<div class="mb-3">
    <label for="{{ $name }}">@lang('translation.' . $name)</label>
    <div class="input-group">
        <input type="file" class="form-control" id="{{ $name }}" name="{{ $name }}">
        <label class="input-group-text" for="{{ $name }}">@lang('translation.Upload')</label>
    </div>
    @if (!empty(getSettingMedia('app_logo')))
        <div class="text-start mt-2">
            <img src="{{ getSettingMedia('app_logo') }}" alt="" width="10%" height="10%">
        </div>
    @endif
</div>
