@extends('layouts.master')

@section('title')
    @lang('translation.users_list')
@endsection

@section('content')
    <div class="row row-main-order">
        <div class="col-12">
            <div class="card-bg px-4">
                @include('components.index_head', [
                    'title' => __('translation.users_list'),
                    'createRoute' => route('users.create'),
                    'placeholder' => __('translation.SearchEmployee'),
                    'btn' => __('translation.addNewUser'),
                    'exportRoute' => route('users.export'),
                    'recordCount' => $users->count(),
                    'fileName' => __('translation.users_report'),
                ])
                <div class="card-body-table">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('translation.document_number_passport') }}</th>
                                            <th>{{ __('translation.name_nationality') }}</th>
                                            <th>{{ __('translation.registered_at') }}</th>
                                            <th>{{ __('translation.user_request_status') }}</th>
                                            <th>{{ __('translation.user_status') }}</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @include('components.datatable.table', [
                                            'data' => $users,
                                            'route' => 'users',
                                            'hasDelete' => false,
                                            'customColumns' => 'users',
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
