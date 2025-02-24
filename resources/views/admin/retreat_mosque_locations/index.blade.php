@extends('layouts.master')

@section('title')
    @lang('translation.Retreat_mosque_locations')
@endsection

@section('content')
    <div class="row row-main-order">
        <div class="col-12">
            <div class="card-bg px-4">
                @include('components.index_head', [
                    'title' => __('translation.Retreat_mosque_locations'),
                    'createRoute' => route('retreat-mosque-locations.create'),
                    'placeholder' => __('translation.SearchRetreatMosqueLocation'),
                    'btn' => __('translation.addNewRetreatMosqueLocation'),
                    'exportRoute' => route('retreat-mosque-locations.export'),
                    'fileName' => __('translation.retreat_mosque_locations_report'),
                ])
                <div class="card-body-table">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('translation.mosque_location_name') }}</th>
                                            <th>{{ __('translation.retreat_mosque_name') }}</th>
                                            <th>{{ __('translation.request_status') }}</th>
                                            <th>{{ __('translation.request_count') }}</th>
                                            <th>{{ __('translation.sort_order') }}</th>
                                            @include('components.common_th')
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @include('components.datatable.table', [
                                            'data' => $retreat_mosque_locations,
                                            'route' => 'retreat-mosque-locations',
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
