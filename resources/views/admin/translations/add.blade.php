@extends('layouts.master')

@section('title')
    {{ __('translation.Translations') }}
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            {{ __('translation.Translations') }}
        @endslot
    @endcomponent
    <div class="row">
        <form method="get" class="form-inline">
            <div class="form-group mb-2">
                <input type="text" name="filter" class="form-control" placeholder="{{ __('translation.Search') }}"
                    value="<?php echo htmlspecialchars(request('filter') ?? ''); ?>">
            </div>
            <button type="submit" class="btn btn-primary mb-2">{{ __('translation.Search') }}</button>
        </form>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">{{ __('translation.Translations') }}</h4>
                    <button type="button" class="btn btn-secondary mb-3" id="add-new-word">@lang('translation.Add New Word')</button>

                    <form class="form_validate" action="{{ route('translations.edit', $lang) }}"
                        enctype="multipart/form-data" method="post">
                        @csrf
                        <div id="new-words-container">
                            @foreach ($words as $key => $val)
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label">@lang('translation.Word')</label>
                                        <input type="text" value="{{ $key }}" name="words[]"
                                            class="form-control" placeholder="@lang('translation.Word')">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">@lang('translation.Translation')</label>
                                        <input type="text" value="{{ $val }}" name="trans[]"
                                            class="form-control" placeholder="@lang('translation.Translation')">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <br>
                        <div class="pagination">
                            {{ $words->links('vendor.pagination.bootstrap-4') }}
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary w-md">@lang('translation.Save')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- end col -->


        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#add-new-word').on('click', function() {
                const newRow = `
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">@lang('translation.Word')</label>
                        <input type="text" name="words[]" class="form-control" placeholder="@lang('translation.New Word')">
                    </div>
                    <div class="col-6">
                        <label class="form-label">@lang('translation.Translation')</label>
                        <input type="text" name="trans[]" class="form-control" placeholder="@lang('translation.New Translation')">
                    </div>
                </div>
            `;
                $('#new-words-container').prepend(newRow);
            });
        });
    </script>
@endsection
