@extends('layouts.master')

@section('title')
    @lang('translation.Retreat_service_categories')
@endsection

@section('content')
    <div class="row row-main-order">
        <div class="col-12">
            <div class="card-bg px-4">
                @include('components.index_head', [
                    'title' => __('translation.Retreat_service_categories'),
                    'createRoute' => route('retreat-service-categories.create'),
                    'placeholder' => __('translation.SearchRetreatServiceCategory'),
                    'btn' => __('translation.addNewRetreatServiceCategory'),
                    'exportRoute' => route('retreat-service-categories.export'),
                    'fileName' => __('translation.retreat_service_categories_report'),
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
                                            'data' => $retreat_service_categories,
                                            'route' => 'retreat-service-categories',
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
