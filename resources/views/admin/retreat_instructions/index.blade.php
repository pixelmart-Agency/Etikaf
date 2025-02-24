@extends('layouts.master')

@section('title')
    @lang('translation.Retreat_instructions')
@endsection

@section('content')
    <div class="row row-main-order">
        <div class="col-12">
            <div class="card-bg px-4">
                @include('components.index_head', [
                    'title' => __('translation.Retreat_instructions'),
                    'createRoute' => route('retreat-instructions.create'),
                    'placeholder' => __('translation.SearchRetreatInstruction'),
                    'btn' => __('translation.addNewRetreatInstruction'),
                    'exportRoute' => route('retreat-instructions.export'),
                    'fileName' => __('translation.retreat_instructions_report'),
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
                                            <th>{{ __('translation.sort_order') }}</th>
                                            @include('components.common_th')
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @include('components.datatable.table', [
                                            'data' => $retreat_instructions,
                                            'route' => 'retreat-instructions',
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
