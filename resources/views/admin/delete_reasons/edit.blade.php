@extends('layouts.master')

@section('title')
    @lang('translation.delete_reasons')
@endsection

@section('content')
    @include('components.breadcrumb', [
        'parent_route' => 'delete-reasons.index',
        'parent_title' => __('translation.delete_reasons'),
        'title' => isset($delete_reason->id)
            ? __('translation.edit_delete_reason') . ' - ' . getTransValue($delete_reason->title)
            : __('translation.add_new_delete_reason'),
    ])
    @include('components.form.header', [
        'action' => isset($delete_reason->id)
            ? route('delete-reasons.update', $delete_reason->id)
            : route('delete-reasons.store'),
        'title' => isset($delete_reason->id) ? __('translation.edit_reason') : __('translation.addNewReason'),
        'method' => isset($delete_reason->id) ? 'PUT' : 'POST',
    ])
    <div class="d-flex gap-3 flex-wrap">
        <fieldset class="flex-grow-1">
            <label for="title" class="block-title fs-14">{{ __('translation.title') }}</label>
            <input type="text" id="title" name="title[ar]" placeholder="{{ __('translation.title') }}"
                value="{{ old('title.ar', getTransValue($delete_reason->title)) }}" class="form-control">
        </fieldset>

    </div>

    @include('components.form.footer', [
        'btn_text' => __('translation.Submit'),
        'confirm_title' => __('translation.confirm_title'),
        'backRoute' => route('delete-reasons.index'),
        // 'confirm_message' => __('translation.confirm_message'),
    ])
@endsection
