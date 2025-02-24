@extends('layouts.master')

@section('title')
    @lang('translation.on_boarding_screens'),
@endsection

@section('content')
    @include('components.breadcrumb', [
        'parent_route' => 'on-boarding-screens.index',
        'parent_title' => __('translation.on_boarding_screens'),
        'title' => isset($on_boarding_screen->id)
            ? __('translation.editOnboardingScreen')
            : __('translation.addNewOnboardingScreen'),
    ])
    @include('components.form.header', [
        'action' => isset($on_boarding_screen->id)
            ? route('on-boarding-screens.update', $on_boarding_screen->id)
            : route('on-boarding-screens.store'),
        'title' => isset($on_boarding_screen->id)
            ? __('translation.editOnboardingScreen')
            : __('translation.addNewOnboardingScreen'),
        'method' => isset($on_boarding_screen->id) ? 'PUT' : 'POST',
    ])
    <div class="d-flex gap-3 flex-wrap">
        <fieldset class="flex-grow-1">
            <label for="name" class="block-title fs-14">{{ __('translation.title') }}</label>
            <input type="text" id="name" name="title[ar]" placeholder="{{ __('translation.title') }}"
                value="{{ old('title.ar', getTransValue($on_boarding_screen->title)) }}" class="form-control">
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="phone_code" class="block-title fs-14">{{ __('translation.Description') }}</label>
            <textarea id="description" name="description[ar]" placeholder="{{ __('translation.Description') }}"
                class="form-control">{{ old('description.ar', getTransValue($on_boarding_screen->description)) }}</textarea>
        </fieldset>
    </div>
    @include('components.image', [
        'single' => $on_boarding_screen,
        'name' => 'image',
        'recommended_size' => '393x413',
    ])
    @include('components.form.footer', [
        'btn_text' => __('translation.Submit'),
        'confirm_title' => __('translation.confirm_title'),
        'backRoute' => route('on-boarding-screens.index'),
        // 'confirm_message' => __('translation.confirm_message'),
    ])
@endsection
