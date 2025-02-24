@extends('layouts.master')

@section('title')
    @lang('translation.Retreat_services')
@endsection

@section('content')
    @include('components.breadcrumb', [
        'parent_route' => 'retreat-services.index',
        'parent_title' => __('translation.Retreat_services'),
        'title' => isset($retreat_service->id) ? __('translation.editService') : __('translation.addNewService'),
    ])
    @include('components.form.header', [
        'action' => isset($retreat_service->id)
            ? route('retreat-services.update', $retreat_service->id)
            : route('retreat-services.store'),
        'title' => isset($retreat_service->id) ? __('translation.editService') : __('translation.addNewService'),
        'method' => isset($retreat_service->id) ? 'PUT' : 'POST',
    ])
    <div class="d-flex gap-3 flex-wrap">
        <fieldset class="flex-grow-1">
            <label for="name" class="block-title fs-14">{{ __('translation.title') }}</label>
            <input type="text" id="name" name="name[ar]" placeholder="{{ __('translation.title') }}"
                value="{{ old('name.ar', getTransValue($retreat_service->name)) }}" class="form-control">
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap">
        <fieldset class="flex-grow-1">
            <label for="description" class="block-title fs-14">{{ __('translation.Description') }}</label>
            <textarea id="description" name="description[ar]" placeholder="{{ __('translation.Description') }}"
                class="form-control">{{ old('description.ar', getTransValue($retreat_service->description)) }}</textarea>
        </fieldset>
    </div>

    <div class="d-flex gap-3 flex-wrap">
        <fieldset class="flex-grow-1">
            <label for="sort_order" class="block-title fs-14">{{ __('translation.sort_order') }}</label>
            <input type="text" id="sort_order" name="sort_order" placeholder="{{ __('translation.sort_order') }}"
                value="{{ old('sort_order', $retreat_service->sort_order) }}" class="form-control">
        </fieldset>
    </div>

    <div class="d-flex gap-3 flex-wrap">
        <fieldset class="flex-grow-1">
            <label for="retreat_service_category_id"
                class="block-title fs-14">{{ __('translation.service_category') }}</label>
            <select id="retreat_service_category_id" name="retreat_service_category_id" class="form-control">
                <option value="">{{ __('translation.select_service_category') }}</option>
                @foreach ($service_categories as $service_category)
                    <option value="{{ $service_category->id }}"
                        {{ old('retreat_service_category_id', $retreat_service->retreat_service_category_id) == $service_category->id ? 'selected' : '' }}>
                        {{ getTransValue($service_category->name) }}
                    </option>
                @endforeach
            </select>
        </fieldset>
    </div>
    @include('components.image', [
        'name' => 'image',
        'single' => $retreat_service,
        'recommended_size' => '200x200',
    ])
    @include('components.form.footer', [
        'btn_text' => __('translation.Submit'),
        'confirm_title' => __('translation.confirm_title'),
        'backRoute' => route('retreat-services.index'),
        // 'confirm_message' => __('translation.confirm_message'),
    ])
@endsection
