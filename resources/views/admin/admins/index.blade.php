@extends('layouts.master')

@section('title')
    @lang('translation.admins_list')
@endsection

@section('content')
    <div class="row row-main-order">
        <div class="col-12">
            <div class="card-bg px-4">
                @include('components.index_head', [
                    'title' => __('translation.admins_list'),
                    'createRoute' => route('admins.create'),
                    'placeholder' => __('translation.SearchAdmin'),
                    'btn' => __('translation.addNewAdmin'),
                ])
                <div class="card-body-table">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('translation.Name') }}</th>
                                            <th>{{ __('translation.Email') }}</th>
                                            <th>{{ __('translation.Mobile') }}</th>
                                            <th></th>
                                            {{-- <th>{{ __('translation.delete') }}</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @include('components.datatable.table', [
                                            'data' => $admins,
                                            'route' => 'admins',
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
