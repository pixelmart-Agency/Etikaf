@extends('layouts.master')

@section('title')
    @lang('translation.pages')
@endsection

@section('content')
    <div class="row row-main-order">
        <div class="col-12">
            <div class="card-bg px-4">
                @include('components.index_head', [
                    'title' => __('translation.pages'),
                    // 'createRoute' => route('pages.create'),
                    'placeholder' => __('translation.SearchPage'),
                    'btn' => __('translation.addNewPage'),
                    'exportRoute' => route('pages.export'),
                    'fileName' => __('translation.pages_report'),
                ])
                <div class="card-body-table">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('translation.title') }}</th>
                                            <th>{{ __('translation.slug') }}</th>
                                            @include('components.common_th', ['hasDelete' => false])
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @include('components.datatable.table', [
                                            'data' => $pages,
                                            'route' => 'pages',
                                            'hasDelete' => false,
                                        ])
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
