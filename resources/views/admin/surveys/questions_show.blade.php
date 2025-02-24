@extends('layouts.master')

@section('title')
    @lang('translation.survey_details')
@endsection

@section('content')
    <div class="row">
        @include('components.breadcrumb', [
            'parent_route' => 'surveys.index',
            'parent_title' => __('translation.surveys'),
            'title' => __('translation.survey_details'),
        ])
        <div class="row row-main-order tab-container">
            <div class="col-12">
                <div class="card-bg px-4">
                    <div class="filter-row d-flex flex-wrap align-items-center gap-2 justify-content-between mb-2">
                        <div class="text-cont">
                            <h2 class="block-title">
                                {{ __('translation.survey_title') . ' : ' . getTransValue($survey->title) }}
                            </h2>
                        </div>
                    </div>
                    <!-- tab-panels -->
                    <div class="tab-panels">
                        <div class="card-body-table panel active" id="card-body-table-panel" role="tabpanel"
                            aria-labelledby="tab-1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped custom-table mb-0 datatable">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('translation.survey_taker') }}</th>
                                                    <th>{{ __('translation.question_title') }}</th>
                                                    <th>{{ __('translation.answer') }}</th>
                                                    <th>{{ __('translation.answer_date') }}</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($questions as $question)
                                                    <tr>
                                                        <td>
                                                            <img width="32" height="32"
                                                                src="{{ $question->user->avatar_url }}"
                                                                class="rounded-circle me-2"
                                                                alt="{{ $question->user->name }}">
                                                            {{ $question->user->name }}
                                                        </td>
                                                        <td>{{ getTransValue($question->retreatRateQuestion->question) }}
                                                        </td>
                                                        <td>
                                                            @if ($question->retreatRateAnswer)
                                                                {{ getTransValue($question->retreatRateAnswer->answer) }}
                                                            @else
                                                                {{ $question->text_answer }}
                                                            @endif
                                                        </td>
                                                        <td>{{ convertToHijri($question->created_at->format('Y-m-d')) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
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
