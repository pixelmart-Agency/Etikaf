<td>
    {{ $single->document_number }}
</td>
<td>
    <img width="32" height="32" src="{{ imageUrl($single->avatar_url) }}" class="rounded-circle me-2" alt="">
    <h2><a href="{{ route('employees.edit', $single->id) }}">
            {{ $single->name }}
            <span>{{ getTransValue($single->country?->name) }}</span>
    </h2>
</td>
@if (auth()->user()->is_admin())
    <td class="tags-td">
        <div class="d-flex gap-2 flex-wrap">
            @if ($single->permissions->count() > 0)
                @foreach ($single->permissions()->limit(3)->get() as $permission)
                    <span class="td-span">{{ __('translation.' . $permission->name) }}</span>
                @endforeach
            @endif
            @if ($single->permissions->count() > 3)
                <span class="td-span-more">
                    {{ $single->permissions->count() - 3 }}
                    +</span>
            @endif
        </div>
    </td>
    <td class="switch-td">
        <div>
            <div class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked-1"
                    name="is_active" {{ old('is_active', $single->is_active) ? 'checked' : '' }} value="1"
                    onclick="switchStatus(this, '{{ route('employees.switch-status', $single) }}')">
                <label class="form-check-label" for="flexSwitchCheckChecked-1">{{ __('translation.active') }}</label>
                <label class="form-check-label" for="flexSwitchCheckChecked-1">{{ __('translation.inactive') }}</label>
            </div>
        </div>
    </td>
@endif
<td>
    {{ convertToHijri($single->created_at) }}
</td>
