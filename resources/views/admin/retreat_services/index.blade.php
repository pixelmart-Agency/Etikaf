@extends('layouts.master')

@section('title')
    @lang('translation.Retreat_services')
@endsection

@section('content')
    <div class="row row-main-order">
        <div class="col-12">
            <div class="card-bg px-4">
                @include('components.index_head', [
                    'title' => __('translation.Retreat_services'),
                    'createRoute' => route('retreat-services.create'),
                    'placeholder' => __('translation.SearchRetreatService'),
                    'btn' => __('translation.addNewRetreatService'),
                    'exportRoute' => route('retreat-services.export'),
                    'fileName' => __('translation.retreat_services_report'),
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
                                            <th>{{ __('translation.service_category') }}</th>
                                            <th>{{ __('translation.sort_order') }}</th>
                                            @include('components.common_th')
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @include('components.datatable.table', [
                                            'data' => $retreat_services,
                                            'route' => 'retreat-services',
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
