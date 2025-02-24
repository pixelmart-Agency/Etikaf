@extends('layouts.master')

@section('title')
    @lang('translation.surveys')
@endsection

@section('content')
    <div class="row row-main-order">
        <div class="col-12">
            <div class="card-bg px-4">
                @include('components.index_head', [
                    'title' => __('translation.surveys'),
                    'createRoute' => route('surveys.create'),
                    'placeholder' => __('translation.SearchSurvey'),
                    'btn' => __('translation.addNewSurvey'),
                    'exportRoute' => route('surveys.export'),
                    'fileName' => __('translation.surveys_report'),
                ])
                <div class="card-body-table">
                    <div class="row">
                        <span class="alert alert-warning" id="no-data-alert">
                            {{ __('translation.only_one_survey_can_be_active') }}
                        </span>
                        <input type="hidden" class="in_survey" value="1">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>{{ __('translation.survey_id') }}</th>
                                            <th>{{ __('translation.survey_title') }}</th>
                                            <th>{{ __('translation.survey_start_date') }}</th>
                                            <th>{{ __('translation.survey_end_date') }}</th>
                                            <th>{{ __('translation.survey_status') }}</th>
                                            <th></th>
                                            @include('components.common_show_th')
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @include('components.datatable.table', [
                                            'data' => $surveys,
                                            'route' => 'surveys',
                                            'hasDelete' => true,
                                            'hasShow' => true,
                                            'hasEdit' => false,
                                            'hasStatus' => true,
                                            'counter' => false,
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
