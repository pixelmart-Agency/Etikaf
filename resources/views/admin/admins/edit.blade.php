@extends('layouts.master')

@section('title')
    @lang('translation.admins_list')
@endsection

@section('content')
    @include('components.breadcrumb', [
        'parent_route' => 'admins.index',
        'parent_title' =>
            isset($admin->id) && $admin->id != Auth::user()->id ? __('translation.admins_list') : null,
        'title' => isset($admin->id)
            ? __('translation.editAdmin') . ' - ' . getTransValue($admin->name)
            : __('translation.addNewAdmin'),
    ])
    @include('components.form.header', [
        'action' => isset($admin->id)
            ? (Auth::user()->id == $admin->id
                ? route('admins.update-profile')
                : route('admins.update', $admin->id))
            : route('admins.store'),
        'title' => isset($admin->id)
            ? ($admin->id == Auth::user()->id
                ? __('translation.editProfile')
                : __('translation.editAdmin'))
            : __('translation.addNewAdmin'),
        'method' => isset($admin->id) ? 'PUT' : 'POST',
    ])
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="name" class="block-title fs-14">{{ __('translation.Name') }}</label>
            <input type="text" id="name" name="name" placeholder="{{ __('translation.Name') }}"
                value="{{ old('name', getTransValue($admin->name)) }}" class="form-control">
        </fieldset>
    </div>
    <input type="hidden" name="user_type" value="{{ App\Enums\UserTypesEnum::ADMIN->value }}">
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="mobile" class="block-title fs-14">{{ __('translation.Mobile') }}</label>
            <input type="text" id="mobile" name="mobile" placeholder="{{ __('translation.Mobile') }}"
                value="{{ old('mobile', $admin->mobile) }}" class="form-control">
        </fieldset>
        <fieldset class="flex-grow-1">
            <label for="email" class="block-title fs-14">{{ __('translation.Email') }}</label>
            <input type="email" id="email" name="email" placeholder="{{ __('translation.Email') }}"
                value="{{ old('email', $admin->email) }}" class="form-control">
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

    @include('components.image', ['single' => $admin, 'name' => 'avatar'])



    @include('components.form.footer', [
        'btn_text' => __('translation.Submit'),
        'confirm_title' => __('translation.confirm_title'),
        'backRoute' => isset($admin->id)
            ? (Auth::user()->id == $admin->id
                ? route('root')
                : route('admins.index'))
            : route('admins.index'),
        // 'confirm_message' => __('translation.confirm_message'),
    ])
@endsection
