@extends('layouts.master')

@section('title')
    @lang('translation.Retreat_mosques')
@endsection

@section('content')
    @include('components.breadcrumb', [
        'parent_route' => 'retreat-mosques.index',
        'parent_title' => __('translation.Retreat_mosques'),
        'title' => isset($retreat_mosque->id) ? __('translation.editMosque') : __('translation.addNewMosque'),
    ])
    @include('components.form.header', [
        'action' => isset($retreat_mosque->id)
            ? route('retreat-mosques.update', $retreat_mosque->id)
            : route('retreat-mosques.store'),
        'title' => isset($retreat_mosque->id) ? __('translation.editMosque') : __('translation.addNewMosque'),
        'method' => isset($retreat_mosque->id) ? 'PUT' : 'POST',
    ])
    <div class="d-flex gap-3 flex-wrap">
        <fieldset class="flex-grow-1">
            <label for="name" class="block-title fs-14">{{ __('translation.mosque_name') }}</label>
            <input type="text" id="name" name="name[ar]" placeholder="{{ __('translation.mosque_name') }}"
                value="{{ old('name.ar', getTransValue($retreat_mosque->name)) }}" class="form-control">
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="phone_code" class="block-title fs-14">{{ __('translation.Description') }}</label>
            <textarea id="description" name="description[ar]" placeholder="{{ __('translation.Description') }}"
                class="form-control">{{ old('description.ar', getTransValue($retreat_mosque->description)) }}</textarea>
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="sort_order" class="block-title fs-14">{{ __('translation.sort_order') }}</label>
            <input type="number" id="sort_order" name="sort_order" placeholder="{{ __('translation.sort_order') }}"
                value="{{ old('sort_order', $retreat_mosque->sort_order) }}" class="form-control input-right-align">
        </fieldset>
    </div>
    @include('components.image', [
        'single' => $retreat_mosque,
        'name' => 'image',
        'recommended_size' => '500x500',
    ])


    @include('components.form.footer', [
        'btn_text' => __('translation.Submit'),
        'confirm_title' => __('translation.confirm_title'),
        'backRoute' => route('retreat-mosques.index'),
        // 'confirm_message' => __('translation.confirm_message'),
    ])
@endsection
