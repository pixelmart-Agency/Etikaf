@extends('layouts.master')

@section('title')
    @lang('translation.Retreat_instructions')
@endsection

@section('content')
    @include('components.breadcrumb', [
        'parent_route' => 'retreat-instructions.index',
        'parent_title' => __('translation.Retreat_instructions'),
        'title' => isset($retreat_instruction->id)
            ? __('translation.editInstruction')
            : __('translation.addNewInstruction'),
    ])
    @include('components.form.header', [
        'action' => isset($retreat_instruction->id)
            ? route('retreat-instructions.update', $retreat_instruction->id)
            : route('retreat-instructions.store'),
        'title' => isset($retreat_instruction->id)
            ? __('translation.editInstruction')
            : __('translation.addNewInstruction'),
        'method' => isset($retreat_instruction->id) ? 'PUT' : 'POST',
    ])
    <div class="d-flex gap-3 flex-wrap">
        <fieldset class="flex-grow-1">
            <label for="name" class="block-title fs-14">{{ __('translation.title') }}</label>
            <input type="text" id="name" name="name[ar]" placeholder="{{ __('translation.title') }}"
                value="{{ old('name.ar', getTransValue($retreat_instruction->name)) }}" class="form-control">
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="phone_code" class="block-title fs-14">{{ __('translation.Description') }}</label>
            <textarea id="description" name="description[ar]" placeholder="{{ __('translation.Description') }}"
                class="form-control">{{ old('description.ar', getTransValue($retreat_instruction->description)) }}</textarea>
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="sort_order" class="block-title fs-14">{{ __('translation.sort_order') }}</label>
            <input type="number" id="sort_order" name="sort_order" placeholder="{{ __('translation.sort_order') }}"
                value="{{ old('sort_order', $retreat_instruction->sort_order) }}" class="form-control input-right-align">
        </fieldset>
    </div>
    @include('components.form.footer', [
        'btn_text' => __('translation.Submit'),
        'confirm_title' => __('translation.confirm_title'),
        'backRoute' => route('retreat-instructions.index'),
        // 'confirm_message' => __('translation.confirm_message'),
    ])
@endsection
