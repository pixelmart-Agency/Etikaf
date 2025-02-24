 <?php
 $i = 1;
 ?>

 @foreach ($data as $index => $single)
     <tr>
         <td>{{ $index + 1 }}</td>
         @if (isset($customColumns))
             @include('components.datatable.' . $customColumns, ['single' => $single])
         @else
             @foreach ($single->toArray(request()) as $key => $value)
                 @if ($key !== 'id')
                     <td>{!! $value !!}</td>
                 @endif
             @endforeach
         @endif
         @if (isset($hasStatus) && $hasStatus)
             <td class="switch-td">
                 <div>
                     <div class="form-check form-switch mb-0">
                         <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked-1"
                             name="is_active" {{ old('is_active', $single->is_active) ? 'checked' : '' }} value="1"
                             onclick="switchStatus(this, '{{ route($route . '.switch-status', $single) }}')">
                         <label class="form-check-label"
                             for="flexSwitchCheckChecked-1">{{ __('translation.active') }}</label>
                         <label class="form-check-label"
                             for="flexSwitchCheckChecked-1">{{ __('translation.inactive') }}</label>
                     </div>
                 </div>
             </td>
         @endif
         @if (!isset($hasEdit) || $hasEdit)
             @include('components.edit', ['route' => route($route . '.edit', $single->id)])
         @endif
         @if (isset($hasShow) && $hasShow)
             @include('components.show', ['route' => route($route . '.show', $single->id)])
         @endif
         @if (!isset($hasDelete) || $hasDelete)
             @include('components.delete', [
                 'route' => route($route . '.destroy', $single->id),
                 'id' => $single->id,
                 'is_deletable' => $single->is_deletable ?? true,
             ])
         @endif
     </tr>
 @endforeach
