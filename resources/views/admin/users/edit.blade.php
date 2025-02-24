@extends('layouts.master')

@section('title')
    @lang('translation.users_list')
@endsection
@if (old('app_user_type', $user->app_user_type))
    @if ($user->app_user_type == 'visitor')
        <style id="dynamic-style">
            #visa_number_div {
                display: block !important;
            }
        </style>
    @else
        <style id="dynamic-style">
            #visa_number_div {
                display: none !important;
            }
        </style>
    @endif
@endif
@section('content')
    @include('components.breadcrumb', [
        'parent_route' => 'users.index',
        'parent_title' => __('translation.users_list'),
        'title' => isset($user->id)
            ? __('translation.editUser') . ' - ' . getTransValue($user->name)
            : __('translation.addNewUser'),
    ])
    @include('components.form.header', [
        'action' => isset($user->id) ? route('users.update', $user->id) : route('users.store'),
        'title' => isset($user->id) ? __('translation.editUser') : __('translation.addNewUser'),
        'method' => isset($user->id) ? 'PUT' : 'POST',
    ])
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="name" class="block-title fs-14">{{ __('translation.Name') }}</label>
            <input type="text" id="name" name="name" placeholder="{{ __('translation.Name') }}"
                value="{{ old('name', getTransValue($user->name)) }}" class="form-control">
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="app_user_type" class="block-title fs-14">{{ __('translation.user_type') }}</label>
            <select name="app_user_type" class="form-control" id="app_user_type">
                <option value="">{{ __('translation.select_user_app_type') }}</option>
                @foreach (App\Enums\AppUserTypesEnum::cases() as $app_user_type)
                    <option value="{{ $app_user_type->value }}"
                        {{ old('app_user_type', $user->app_user_type) == $app_user_type->value ? 'selected' : '' }}>
                        {{ __('translation.' . $app_user_type->value) }}
                    </option>
                @endforeach
            </select>
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3" id="visa_number_div">
        <fieldset class="flex-grow-1">
            <label for="visa_number" class="block-title fs-14">{{ __('translation.visa_number') }}</label>
            <input type="text" id="visa_number" name="visa_number" placeholder="{{ __('translation.visa_number') }}"
                value="{{ old('visa_number', $user->visa_number) }}" class="form-control">
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="document_number" class="block-title fs-14">{{ __('translation.document_type') }}</label>
            <select id="document_type" name="document_type" class="form-control">
                <option value="">{{ __('translation.select_document_type') }}</option>
                @foreach (App\Enums\DocumentTypesEnum::cases() as $document_type)
                    <option value="{{ $document_type->value }}"
                        {{ old('document_type', $user->document_type) == $document_type->value ? 'selected' : '' }}>
                        {{ __('translation.' . $document_type->value) }}
                    </option>
                @endforeach
            </select>
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="document_number" class="block-title fs-14">{{ __('translation.National ID') }}</label>
            <input type="text" id="document_number" name="document_number"
                placeholder="{{ __('translation.National ID') }}"
                value="{{ old('document_number', $user->document_number) }}" class="form-control">
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="country_id" class="block-title fs-14">{{ __('translation.Nationality') }}</label>
            <select id="country_id" name="country_id" class="form-control">
                <option value="">{{ __('translation.select_country') }}</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}"
                        {{ old('country_id', $user->country_id) == $country->id ? 'selected' : '' }}>
                        {{ getTransValue($country->name) }}
                    </option>
                @endforeach
            </select>
        </fieldset>
        <fieldset class="flex-grow-1">
            <label for="birthday" class="block-title fs-14">{{ __('translation.Date of Birth') }}</label>
            <input type="text" id="birthday" name="birthday" placeholder="{{ __('translation.Date of Birth') }}"
                format="YYYY-MM-DD" value="{{ old('birthday', $user->birthday) }}" class="form-control datetimepicker">
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="mobile" class="block-title fs-14">{{ __('translation.Mobile') }}</label>
            <input type="text" id="mobile" name="mobile" placeholder="{{ __('translation.Mobile') }}"
                value="{{ old('mobile', $user->mobile) }}" class="form-control">
        </fieldset>
        <fieldset class="flex-grow-1">
            <label for="email" class="block-title fs-14">{{ __('translation.Email') }}</label>
            <input type="email" id="email" name="email" placeholder="{{ __('translation.Email') }}"
                value="{{ old('email', $user->email) }}" class="form-control">
        </fieldset>
    </div>
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
                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>
                    {{ __('translation.male') }}
                </option>
                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>
                    {{ __('translation.female') }}
                </option>
            </select>
        </fieldset>
        <fieldset class="flex-grow-1">
            <label for="is_active" class="block-title fs-14">{{ __('translation.user_status') }}</label>
            <div>
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked-1"
                        name="is_active" {{ old('is_active', $user->is_active) ? 'checked' : '' }} value="1">
                    <label class="form-check-label" for="flexSwitchCheckChecked-1">{{ __('translation.active') }}</label>
                    <label class="form-check-label"
                        for="flexSwitchCheckChecked-1">{{ __('translation.inactive') }}</label>
                </div>
            </div>
        </fieldset>
    </div>
    @include('components.image', ['single' => $user, 'name' => 'avatar'])



    @include('components.form.footer', [
        'btn_text' => __('translation.Submit'),
        'confirm_title' => __('translation.confirm_title'),
        'backRoute' => route('users.index'),
        // 'confirm_message' => __('translation.confirm_message'),
    ])
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            let styleTag = $('<style id="dynamic-style"></style>').appendTo('head');

            $('#app_user_type').change(function() {
                if ($(this).val() == 'visitor') {
                    console.log($(this).val());
                    styleTag.html('#visa_number_div { display: block !important; }');
                } else {
                    console.log($(this).val());
                    styleTag.html('#visa_number_div { display: none !important; }');
                }
            });
        });
    </script>
@endsection
