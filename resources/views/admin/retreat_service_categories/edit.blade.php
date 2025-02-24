@extends('layouts.master')

@section('title')
    @lang('translation.Retreat_service_categories')
@endsection

@section('content')
    @include('components.breadcrumb', [
        'parent_route' => 'retreat-service-categories.index',
        'parent_title' => __('translation.Retreat_service_categories'),
        'title' => isset($retreat_service_category->id)
            ? __('translation.editServiceCategory')
            : __('translation.addNewServiceCategory'),
    ])
    @include('components.form.header', [
        'action' => isset($retreat_service_category->id)
            ? route('retreat-service-categories.update', $retreat_service_category->id)
            : route('retreat-service-categories.store'),
        'title' => isset($retreat_service_category->id)
            ? __('translation.editServiceCategory')
            : __('translation.addNewServiceCategory'),
        'method' => isset($retreat_service_category->id) ? 'PUT' : 'POST',
    ])
    <div class="d-flex gap-3 flex-wrap">
        <fieldset class="flex-grow-1">
            <label for="name" class="block-title fs-14">{{ __('translation.title') }}</label>
            <input type="text" id="name" name="name[ar]" placeholder="{{ __('translation.title') }}"
                value="{{ old('name.ar', getTransValue($retreat_service_category->name)) }}" class="form-control">
        </fieldset>
    </div>
    @include('components.form.footer', [
        'btn_text' => __('translation.Submit'),
        'confirm_title' => __('translation.confirm_title'),
        'backRoute' => route('retreat-service-categories.index'),
        // 'confirm_message' => __('translation.confirm_message'),
    ])
@endsection
