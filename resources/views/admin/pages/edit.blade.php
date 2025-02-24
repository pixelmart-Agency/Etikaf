@extends('layouts.master')

@section('title')
    @lang('translation.pages')
@endsection
@section('content')
    @include('components.breadcrumb', [
        'parent_route' => 'pages.index',
        'parent_title' => __('translation.pages'),
        'title' => isset($page->id)
            ? __('translation.editPage') . ' - ' . getTransValue($page->name)
            : __('translation.addNewPage'),
    ])
    @include('components.form.header', [
        'action' => isset($page->id) ? route('pages.update', $page->id) : route('pages.store'),
        'title' => isset($page->id) ? __('translation.editPage') : __('translation.addNewPage'),
        'method' => isset($page->id) ? 'PUT' : 'POST',
    ])
    <div class="d-flex gap-3 flex-wrap">
        <fieldset class="flex-grow-1">
            <label for="name" class="block-title fs-14">{{ __('translation.title') }}</label>
            <input type="text" id="name" name="name[ar]" placeholder="{{ __('translation.title') }}"
                value="{{ old('name.ar', getTransValue($page->name)) }}" class="form-control">
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="slug" class="block-title fs-14">{{ __('translation.slug') }}</label>
            <input type="text" id="slug" name="slug" placeholder="{{ __('translation.slug') }}"
                {{ isset($page->slug) ? 'readonly' : '' }} value="{{ old('slug', $page->slug) }}" class="form-control">
        </fieldset>
    </div>

    <div id="blocks-container" class="d-flex flex-column gap-3 mt-3">
        <label for="content_title" class="block-title fs-14">{{ __('translation.content') }}</label>
        @if (empty($decodedContent['block']['title']) && old('content.block.title') == null)
            <!-- Empty block if no previous content -->
            <div class="my-block" data-index="0">
                <fieldset class="flex-grow-1">
                    <div class="my-block-content">
                        <div class="my-block-title">
                            <input type="text" name="content[block][title][]"
                                placeholder="{{ __('translation.block_title') }}" class="form-control"
                                value="{{ old('content.block.title.0') }}">
                        </div>
                        <div class="my-block-contents">
                            <div class="my-block-body mt-2 position-relative">
                                <textarea name="content[block][body][0][]" placeholder="{{ __('translation.block_content') }}" class="form-control">{{ old('content.block.body.0.0') }}</textarea>
                                <button type="button" class="delete-btn position-absolute" onclick="deleteContent(this)">
                                    {{ __('translation.delete_content') }}</button>
                            </div>
                        </div>
                        <button type="button" class="main-btn fs-14 mt-2" onclick="addContent(this)">+
                            {{ __('translation.add_content') }}</button>
                        <button type="button" class="delete-page-content main-btn bg-main-color text-blue mt-2"
                            onclick="deleteBlock(this)"> {{ __('translation.delete_block') }}</button>
                    </div>
                </fieldset>
            </div>
        @else
            @foreach ($decodedContent['block']['title'] ?? [] as $blockIndex => $title)
                <div class="my-block" data-index="{{ $blockIndex }}">
                    <fieldset class="flex-grow-1">
                        <div class="my-block-content">
                            <div class="my-block-title">
                                <input type="text" name="content[block][title][]"
                                    placeholder="{{ __('translation.block_title') }}" class="form-control"
                                    value="{{ old('content.block.title.' . $blockIndex, $title) }}">
                            </div>
                            <div class="my-block-contents">
                                @foreach ($decodedContent['block']['body'][$blockIndex] ?? [] as $contentIndex => $content)
                                    <div class="my-block-body mt-2 position-relative">
                                        <textarea name="content[block][body][{{ $blockIndex }}][]" placeholder="{{ __('translation.block_content') }}"
                                            class="form-control">{{ old('content.block.body.' . $blockIndex . '.' . $contentIndex, $content) }}</textarea>
                                        <button type="button" class="delete-btn position-absolute"
                                            onclick="deleteContent(this)">
                                            {{ __('translation.delete_content') }}</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="main-btn fs-14 mt-2" onclick="addContent(this)">+
                                {{ __('translation.add_content') }}</button>
                            <button type="button" class="delete-page-content main-btn bg-main-color text-blue mt-2"
                                onclick="deleteBlock(this)"> {{ __('translation.delete_block') }}</button>
                        </div>
                    </fieldset>
                </div>
            @endforeach
        @endif
    </div>



    <button type="button" class="main-btn bg-gold mt-2" onclick="addBlock()">+
        {{ __('translation.add_block') }}</button>
    </div>
    @include('components.form.footer', [
        'btn_text' => __('translation.Submit'),
        'confirm_title' => __('translation.confirm_title'),
        'backRoute' => route('pages.index'),
        // 'confirm_message' => __('translation.confirm_message'),
    ])
@endsection
