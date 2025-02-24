@extends('layouts.master')

@section('title')
    @lang('translation.survey_details') - #{{ $survey->id }}
@endsection

@section('content')
    @include('components.breadcrumb', [
        'parent_route' => 'surveys.index',
        'parent_title' => __('translation.surveys'),
        'title' => __('translation.survey_details') . ' - ' . $survey->id,
    ])
    <div class="col-12">
        <div class="row row-main-order tab-container">
            <div class="card-bg px-4">
                <div class="filter-row d-flex flex-wrap align-items-center gap-2 justify-content-between mb-2">
                    <div class="text-cont">
                        <h2 class="block-title">
                            {{ __('translation.survey_title') }} : {{ getTransValue($survey->title) }}
                        </h2>
                        <span class="d-block fs-16 text-light-blue">#{{ $survey->id }}</span>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-2">

                        <!-- tabs -->
                        <div class="nav nav-tabs" role="tablist">
                            <button class="nav-item tab active" role="tab" aria-selected="true" id="tab-1"
                                aria-controls="card-body-table-panel" tabindex="0">
                                <span class="nav-link">{{ __('translation.answers') }}</span>
                            </button>
                            <button class="nav-item tab" role="tab" aria-selected="false" id="tab-2"
                                aria-controls="survey-details-panel" tabindex="-1">
                                <span class="nav-link">{{ __('translation.statistics') }}</span>
                            </button>
                        </div>

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
                                                <th>{{ __('translation.national_id') }}</th>
                                                <th>{{ __('translation.survey_answe_date') }}</th>
                                                <th>{{ __('translation.number_of_answers') }}</th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>
                                                        <img width="32" height="32" src="{{ $user->avatar_url }}"
                                                            class="rounded-circle me-2" alt="{{ $user->name }}">
                                                        {{ $user->name }}
                                                    </td>
                                                    <td>{{ $user->document_number }}</td>
                                                    <td>{{ convertToHijri($user->survey_answer_date) }}</td>
                                                    <td>{{ $survey->retreatRateQuestions->count() }}/{{ $user->retreat_rate_questions_count }}
                                                    </td>
                                                    <td class="show-td">
                                                        <a
                                                            href="{{ route('retreat-rate-questions.show', [$survey->id, $user->id]) }}">

                                                            <i aria-hidden="true"></i>
                                                            {{ __('translation.view') }}</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body-table panel" id="survey-details-panel" role="tabpanel" aria-labelledby="tab-2">
                        <div class="card-gray-bg">
                            <h3 class="block-title fs-16 mb-4">{{ __('translation.total_stats') }}</h3>
                            <div class="card-bg bar-title d-flex rounded-3 mb-0">
                                <div class="flex-grow-1">
                                    <h5 class="block-title fs-14">{{ __('translation.sent_count') }}</h5>
                                    <p class="fs-14 text-light-blue m-0">{{ $usersCount }}
                                        {{ __('translation.persons') }}</p>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="block-title fs-14">{{ __('translation.received_count') }}</h5>
                                    <p class="fs-14 text-light-blue m-0">{{ $surveysCount }}
                                        {{ __('translation.persons') }}</p>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="block-title fs-14">{{ __('translation.received_percent') }}</h5>
                                    <p class="fs-14 text-light-blue m-0">%{{ $surveysPercent }}</p>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap align-items-center">

                                <div class="bar-chart" aria-label="مخطط شريطي يوضح مستويات التقدم">
                                    @foreach ($surveyStats as $stat)
                                        <div class="item">
                                            <span class="title" id="{{ $stat->status_id }}">{{ $stat->name }}</span>
                                            <div class="bar" role="progressbar" aria-labelledby="{{ $stat->status_id }}"
                                                aria-valuenow="{{ $stat->percent }}" aria-valuemin="0" aria-valuemax="100">
                                                <div class="item-progress {{ $stat->class }}"
                                                    style="width: {{ $stat->percent }}%;">
                                                </div>
                                            </div>
                                            <span class="percent">{{ $stat->percent }}%</span>
                                        </div>
                                    @endforeach

                                </div>

                            </div>
                        </div>
                        <div class="card-gray-bg">
                            <h3 class="block-title fs-16 mb-4">{{ __('translation.answers_stats') }}</h3>
                            <div class="row row-bar-lg">
                                @foreach ($surveyRateQuestions as $surveyRateQuestion)
                                    <div class="col-12 col-md-6">
                                        <div class="card-bg mb-0 rounded-16">
                                            <h3 class="block-title fs-16">
                                                {{ $surveyRateQuestion->question }}
                                            </h3>
                                            <p class="fs-14 text-light-blue">{{ $surveyRateQuestion->people_count }}
                                                {{ __('translation.persons') }}
                                            </p>
                                            <div class="bar-chart flex-column" aria-label="مخطط شريطي يوضح مستويات التقدم">
                                                @foreach ($surveyRateQuestion->retreatRateAnswers as $answer)
                                                    <div class="item">
                                                        <span class="title" id="{{ $answer->status_id }}"
                                                            style="background-color: rgba({{ hexToRgb($answer->text_color) }}, 0.2);">
                                                            <span
                                                                style="color: {{ $answer->text_color }};">{{ $answer->answer }}</span>
                                                        </span>

                                                        <div class="bar" role="progressbar"
                                                            aria-labelledby="{{ $answer->answerus_id }}"
                                                            aria-valuenow="{{ $answer->survey_answer_percent }}"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            <div class="item-progress {{ $answer->class }}"
                                                                style="width: {{ $answer->survey_answer_percent }}%;background-color: rgba({{ hexToRgb($answer->text_color) }}, 0.5);">
                                                            </div>
                                                        </div>
                                                        <span class="percent">{{ $answer->survey_answer_percent }}%</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
