@extends('layouts.master')

@section('title')
    @lang('translation.reasons')
@endsection

@section('content')
    <div class="row row-main-order">
        <div class="col-12">
            <div class="card-bg px-4">
                @include('components.index_head', [
                    'title' => __('translation.reasons'),
                    'createRoute' => route('reasons.create'),
                    'placeholder' => __('translation.SearchReason'),
                    'btn' => __('translation.addNewReason'),
                    'exportRoute' => route('reasons.export'),
                    'fileName' => __('translation.reasons_report'),
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
                                            @include('components.common_th')
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @include('components.datatable.table', [
                                            'data' => $reasons,
                                            'route' => 'reasons',
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
