@extends('layouts.master')

@section('title')
    @lang('translation.reasons')
@endsection

@section('content')
    @include('components.breadcrumb', [
        'parent_route' => 'reasons.index',
        'parent_title' => __('translation.reasons'),
        'title' => isset($reason->id)
            ? __('translation.edit_reason') . ' - ' . getTransValue($reason->title)
            : __('translation.add_new_reason'),
    ])
    @include('components.form.header', [
        'action' => isset($reason->id) ? route('reasons.update', $reason->id) : route('reasons.store'),
        'title' => isset($reason->id) ? __('translation.edit_reason') : __('translation.addNewReason'),
        'method' => isset($reason->id) ? 'PUT' : 'POST',
    ])
    <div class="d-flex gap-3 flex-wrap">
        <fieldset class="flex-grow-1">
            <label for="title" class="block-title fs-14">{{ __('translation.title') }}</label>
            <input type="text" id="title" name="title[ar]" placeholder="{{ __('translation.title') }}"
                value="{{ old('title.ar', getTransValue($reason->title)) }}" class="form-control">
        </fieldset>

    </div>

    @include('components.form.footer', [
        'btn_text' => __('translation.Submit'),
        'confirm_title' => __('translation.confirm_title'),
        'backRoute' => route('reasons.index'),
        // 'confirm_message' => __('translation.confirm_message'),
    ])
@endsection
