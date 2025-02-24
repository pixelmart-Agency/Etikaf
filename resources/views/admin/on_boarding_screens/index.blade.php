@extends('layouts.master')

@section('title')
    @lang('translation.on_board screens')
@endsection

@section('content')
    <div class="row row-main-order">
        <div class="col-12">
            <div class="card-bg px-4">
                @include('components.index_head', [
                    'title' => __('translation.on_board screens'),
                    'createRoute' => route('on-boarding-screens.create'),
                    'placeholder' => __('translation.SearchOnboardingScreen'),
                    'btn' => __('translation.addNewOnboardingScreen'),
                    'exportRoute' => route('on-boarding-screens.export'),
                    'fileName' => __('translation.on_boarding_screens_report'),
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
                                            'data' => $on_boarding_screens,
                                            'route' => 'on-boarding-screens',
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
