@extends('layouts.master')

@section('title')
    @lang('translation.Retreat_mosques')
@endsection

@section('content')
    <div class="row row-main-order">
        <div class="col-12">
            <div class="card-bg px-4">
                @include('components.index_head', [
                    'title' => __('translation.Retreat_mosques'),
                    'createRoute' => route('retreat-mosques.create'),
                    'placeholder' => __('translation.SearchRetreatMosque'),
                    'btn' => __('translation.addNewRetreatMosque'),
                    'exportRoute' => route('retreat-mosques.export'),
                    'fileName' => __('translation.retreat_mosques_report'),
                ])
                <div class="card-body-table">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('translation.mosque_name') }}</th>
                                            <th>{{ __('translation.sort_order') }}</th>
                                            @include('components.common_th')
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @include('components.datatable.table', [
                                            'data' => $retreat_mosques,
                                            'route' => 'retreat-mosques',
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
