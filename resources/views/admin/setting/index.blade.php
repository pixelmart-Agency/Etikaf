@extends('layouts.master')

@section('title')
    @lang('translation.Settings')
@endsection

@section('content')
    @include('components.breadcrumb', [
        'parent_route' => 'retreat-instructions.index',
        'parent_title' => __('translation.Settings'),
    ])
    @include('components.form.header', [
        'action' => route('settings.store'),
        'title' => __('translation.Settings'),
        'method' => 'POST',
    ])
    <div class="d-flex gap-3 flex-wrap">
        <fieldset class="flex-grow-1">
            <label for="app_name_ar" class="block-title fs-14">{{ __('translation.app_name') }}</label>
            <input type="text" id="app_name_ar" name="app_name_ar" placeholder="{{ __('translation.app_name') }}"
                value="{{ old('app_name_ar', getSetting('app_name_ar')) }}" class="form-control">
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="app_email" class="block-title fs-14">{{ __('translation.app_email') }}</label>
            <input type="text" id="app_email" name="app_email" placeholder="{{ __('translation.app_email') }}"
                value="{{ old('app_email', getSetting('app_email')) }}" class="form-control">
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="app_email" class="block-title fs-14">{{ __('translation.rate_question') }}</label>
            <input type="text" id="rate_question" name="rate_question"
                placeholder="{{ __('translation.rate_question') }}"
                value="{{ old('rate_question', getSetting('rate_question')) }}" class="form-control">
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="app_email" class="block-title fs-14">{{ __('translation.rate_question_title') }}</label>
            <input type="text" id="rate_question_title" name="rate_question_title"
                placeholder="{{ __('translation.rate_question_title') }}"
                value="{{ old('rate_question_title', getSetting('rate_question_title')) }}" class="form-control">
        </fieldset>
    </div>
    @include('components.setting_image', ['name' => 'app_logo'])

    <div class="d-flex gap-3 flex-wrap mt-3">

        @include('components.form.footer', [
            'btn_text' => __('translation.Submit'),
            'confirm_title' => __('translation.confirm_title'),
            'backRoute' => route('root'),
            // 'confirm_message' => __('translation.confirm_message'),
        ])
    @endsection
