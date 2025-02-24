<td>
    {{ __('translation.' . $single->document_type) . ' : ' . $single->document_number }}
</td>
<td>
    <img width="32" height="32" src="{{ imageUrl($single->avatar_url) }}" class="rounded-circle me-2" alt="">
    <h2><a href="{{ route('users.edit', $single->id) }}">
            {{ $single->name }}
            <span>{{ getTransValue($single->country?->name) }}</span>
    </h2>
</td>
<td>
    {{ convertToHijri($single->created_at) }}
</td>
<td class="{{ $single->status_class }}">
    <span>{{ $single->request_status }}</span>
</td>
<td class="switch-td">
    <div>
        <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked-1" name="is_active"
                {{ old('is_active', $single->is_active) ? 'checked' : '' }} value="1"
                onclick="switchStatus(this, '{{ route('users.switch-status', $single) }}')">
            <label class="form-check-label" for="flexSwitchCheckChecked-1">{{ __('translation.active') }}</label>
            <label class="form-check-label" for="flexSwitchCheckChecked-1">{{ __('translation.inactive') }}</label>
        </div>
    </div>
</td>
