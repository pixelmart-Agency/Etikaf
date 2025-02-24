@extends('layouts.master')

@section('title')
    @lang('translation.employees_list')
@endsection

@section('content')
    @include('components.breadcrumb', [
        'parent_route' => 'employees.index',
        'parent_title' => __('translation.employees_list'),
        'title' => isset($employee->id)
            ? __('translation.editEmployee') . ' - ' . getTransValue($employee->name)
            : __('translation.addNewEmployee'),
    ])
    @include('components.form.header', [
        'action' => isset($employee->id) ? route('employees.update', $employee->id) : route('employees.store'),
        'title' => isset($employee->id) ? __('translation.editEmployee') : __('translation.addNewEmployee'),
        'method' => isset($employee->id) ? 'PUT' : 'POST',
    ])
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="name" class="block-title fs-14">{{ __('translation.Name') }}</label>
            <input type="text" id="name" name="name" placeholder="{{ __('translation.Name') }}"
                value="{{ old('name', getTransValue($employee->name)) }}" class="form-control">
        </fieldset>
        <fieldset class="flex-grow-1">
            <label for="document_number" class="block-title fs-14">{{ __('translation.National ID') }}</label>
            <input type="text" id="document_number" name="document_number"
                placeholder="{{ __('translation.National ID') }}"
                value="{{ old('document_number', $employee->document_number) }}" class="form-control">
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="country_id" class="block-title fs-14">{{ __('translation.Nationality') }}</label>
            <select id="country_id" name="country_id" class="form-control">
                <option value="">{{ __('translation.select_country') }}</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}"
                        {{ old('country_id', $employee->country_id) == $country->id ? 'selected' : '' }}>
                        {{ getTransValue($country->name) }}
                    </option>
                @endforeach
            </select>
        </fieldset>
        <fieldset class="flex-grow-1">
            <label for="birthday" class="block-title fs-14">{{ __('translation.Date of Birth') }}</label>
            <input type="text" id="birthday" name="birthday" placeholder="{{ __('translation.Date of Birth') }}"
                value="{{ old('birthday', $employee->birthday) }}" class="form-control datetimepicker">
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="mobile" class="block-title fs-14">{{ __('translation.Mobile') }}</label>
            <input type="text" id="mobile" name="mobile" placeholder="{{ __('translation.Mobile') }}"
                value="{{ old('mobile', $employee->mobile) }}" class="form-control">
        </fieldset>
        <fieldset class="flex-grow-1">
            <label for="email" class="block-title fs-14">{{ __('translation.Email') }}</label>
            <input type="email" id="email" name="email" placeholder="{{ __('translation.Email') }}"
                value="{{ old('email', $employee->email) }}" class="form-control">
        </fieldset>
    </div>
    @if (auth()->user()->is_admin())
        <div class="form-group mb-0 mt-4">
            <label for="selectEmployeePermissions" class="block-title fs-16">
                {{ __('translation.employee_permissions') }}
                <span class="ms-1 text-red text-red-f5">*</span></label>
            <div class="form-group form-focus select-focus mb-0">
                <select id="selectEmployeePermissions" name="permissions[]" class="validate[required]"
                    placeholder="{{ __('translation.select_permissions') }}" multiple="multiple">
                    @foreach ($permissions as $permission)
                        <option value="{{ $permission->id }}"
                            {{ in_array($permission->id, $employee->permissions->pluck('id')->toArray()) ||
                            in_array($permission->id, old('permissions', []))
                                ? 'selected'
                                : '' }}>
                            {{ __('translation.' . $permission->name) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1 password-container">
            <label for="password" class="block-title fs-14">{{ __('translation.Password') }}</label>
            <button type="button" id="toggle-password" aria-label="Show password" aria-pressed="false">
            </button>
            <input type="password" id="password" name="password" placeholder="{{ __('translation.Password') }}"
                value="{{ old('password') }}" class="form-control">
        </fieldset>
        <fieldset class="flex-grow-1 password-container">
            <label for="password_confirmation" class="block-title fs-14">{{ __('translation.Confirm Password') }}</label>
            <button type="button" id="toggle-confirm-password" aria-label="Show password" aria-pressed="false">
            </button>
            <input type="password" id="password_confirmation" name="password_confirmation"
                placeholder="{{ __('translation.Confirm Password') }}" value="{{ old('password_confirmation') }}"
                class="form-control">
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="gender" class="block-title fs-14">{{ __('translation.Gender') }}</label>
            <select id="gender" name="gender" class="form-control">
                <option value="male" {{ old('gender', $employee->gender) == 'male' ? 'selected' : '' }}>
                    {{ __('translation.male') }}
                </option>
                <option value="female" {{ old('gender', $employee->gender) == 'female' ? 'selected' : '' }}>
                    {{ __('translation.female') }}
                </option>
            </select>
        </fieldset>
        @if (auth()->user()->is_admin())
            <fieldset class="flex-grow-1">
                <label for="is_active" class="block-title fs-14">{{ __('translation.employee_status') }}</label>
                <div>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked-1"
                            name="is_active" {{ old('is_active', $employee->is_active) ? 'checked' : '' }}
                            value="1">
                        <label class="form-check-label"
                            for="flexSwitchCheckChecked-1">{{ __('translation.active') }}</label>
                        <label class="form-check-label"
                            for="flexSwitchCheckChecked-1">{{ __('translation.inactive') }}</label>
                    </div>
                </div>
            </fieldset>
        @endif
    </div>
    @include('components.image', ['single' => $employee, 'name' => 'avatar'])



    @include('components.form.footer', [
        'btn_text' => __('translation.Submit'),
        'confirm_title' => __('translation.confirm_title'),
        'backRoute' => route('employees.index'),
        // 'confirm_message' => __('translation.confirm_message'),
    ])
@endsection
