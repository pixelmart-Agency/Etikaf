@extends('layouts.master')

@section('title')
    @lang('translation.Countries')
@endsection

@section('content')
    @include('components.breadcrumb', [
        'parent_route' => 'countries.index',
        'parent_title' => __('translation.Countries'),
        'title' => isset($country->id)
            ? __('translation.editCountry') . ' - ' . getTransValue($country->name)
            : __('translation.addNewCountry'),
    ])
    @include('components.form.header', [
        'action' => isset($country->id) ? route('countries.update', $country->id) : route('countries.store'),
        'title' => isset($country->id) ? __('translation.editCountry') : __('translation.addNewCountry'),
        'method' => isset($country->id) ? 'PUT' : 'POST',
    ])
    <div class="d-flex gap-3 flex-wrap">
        <fieldset class="flex-grow-1">
            <label for="name" class="block-title fs-14">{{ __('translation.country_name') }}</label>
            <input type="text" id="name" name="name[ar]" placeholder="{{ __('translation.country_name') }}"
                value="{{ old('name.ar', getTransValue($country->name)) }}" class="form-control">
        </fieldset>

    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="phone_code" class="block-title fs-14">{{ __('translation.country_phone_code') }}</label>
            <input type="number" id="phone_code" name="phone_code" placeholder="{{ __('translation.country_phone_code') }}"
                value="{{ old('phone_code', $country->phone_code) }}" class="form-control input-right-align">
        </fieldset>
    </div>

    @include('components.form.footer', [
        'btn_text' => __('translation.Submit'),
        'confirm_title' => __('translation.confirm_title'),
        'backRoute' => route('countries.index'),
        // 'confirm_message' => __('translation.confirm_message'),
    ])
@endsection
