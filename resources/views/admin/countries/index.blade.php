@extends('layouts.master')

@section('title')
    @lang('translation.Countries')
@endsection

@section('content')
    <div class="row row-main-order">
        <div class="col-12">
            <div class="card-bg px-4">
                @include('components.index_head', [
                    'title' => __('translation.Countries'),
                    'createRoute' => route('countries.create'),
                    'placeholder' => __('translation.SearchCountry'),
                    'btn' => __('translation.addNewCountry'),
                    'exportRoute' => route('countries.export'),
                    'fileName' => __('translation.countries_report'),
                ])
                <div class="card-body-table">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('translation.country_name') }}</th>
                                            <th>{{ __('translation.country_code') }}</th>
                                            @include('components.common_th')
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @include('components.datatable.table', [
                                            'data' => $countries,
                                            'route' => 'countries',
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
