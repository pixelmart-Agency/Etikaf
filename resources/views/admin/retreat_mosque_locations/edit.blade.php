@extends('layouts.master')

@section('title')
    @lang('translation.Retreat_mosque_locations')
@endsection

@section('content')
    <div class="row">
        <div class="row">
            @include('components.breadcrumb', [
                'parent_route' => 'retreat-mosque-locations.index',
                'parent_title' => __('translation.Retreat_mosque_locations'),
                'title' => isset($retreat_mosque_location->id)
                    ? __('translation.editMosqueLocation')
                    : __('translation.addNewMosqueLocation'),
            ])
        </div>
        @include('components.form.header', [
            'action' => isset($retreat_mosque_location->id)
                ? route('retreat-mosque-locations.update', $retreat_mosque_location->id)
                : route('retreat-mosque-locations.store'),
            'title' => isset($retreat_mosque_location->id)
                ? __('translation.editMosqueLocation')
                : __('translation.addNewMosqueLocation'),
            'method' => isset($retreat_mosque_location->id) ? 'PUT' : 'POST',
        ])
        <div class="d-flex gap-3 flex-wrap">
            <fieldset class="flex-grow-1">
                <label for="name" class="block-title fs-14">{{ __('translation.mosque_location_name') }}</label>
                <input type="text" id="name" name="name[ar]" placeholder="{{ __('translation.mosque_location_name') }}"
                    value="{{ old('name.ar', getTransValue($retreat_mosque_location->name)) }}" class="form-control">
            </fieldset>
        </div>
        <div class="d-flex gap-3 flex-wrap mt-3">
            <fieldset class="flex-grow-1">
                <label for="phone_code" class="block-title fs-14">{{ __('translation.retreat_mosque') }}</label>
                <select id="retreat_mosque_id" name="retreat_mosque_id" class="form-control">
                    <option value="">{{ __('translation.select_mosque') }}</option>
                    @foreach ($retreat_mosques as $retreat_mosque)
                        <option value="{{ $retreat_mosque->id }}"
                            {{ old('retreat_mosque_id', $retreat_mosque_location->retreat_mosque_id) == $retreat_mosque->id ? 'selected' : '' }}>
                            {{ getTransValue($retreat_mosque->name) }}
                        </option>
                    @endforeach
                </select>
            </fieldset>
        </div>
        <div class="d-flex gap-3 flex-wrap mt-3">
            <fieldset class="flex-grow-1">
                <label for="phone_code" class="block-title fs-14">{{ __('translation.Location') }}</label>
                @include('components.inputs.map', [
                    'location' => $retreat_mosque_location->location,
                ])
        </div>
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="phone_code" class="block-title fs-14">{{ __('translation.Description') }}</label>
            <textarea id="description" name="description[ar]" placeholder="{{ __('translation.Description') }}"
                class="form-control">{{ old('description.ar', getTransValue($retreat_mosque_location->description)) }}</textarea>
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="sort_order" class="block-title fs-14">{{ __('translation.sort_order') }}</label>
            <input type="number" id="sort_order" name="sort_order" placeholder="{{ __('translation.sort_order') }}"
                value="{{ old('sort_order', $retreat_mosque_location->sort_order) }}"
                class="form-control input-right-align">
        </fieldset>
    </div>
    @include('components.image', [
        'single' => $retreat_mosque_location,
        'name' => 'image',
        'recommended_size' => '500x500',
    ])


    @include('components.form.footer', [
        'btn_text' => __('translation.Submit'),
        'confirm_title' => __('translation.confirm_title'),
        'backRoute' => route('retreat-mosque-locations.index'),
        // 'confirm_message' => __('translation.confirm_message'),
    ])
@endsection
