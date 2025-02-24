@extends('layouts.master')

@section('title')
    @lang('translation.employees_list')
@endsection

@section('content')
    <div class="row row-main-order">
        <div class="col-12">
            <div class="card-bg px-4">
                @include('components.index_head', [
                    'title' => __('translation.employees_list'),
                    'createRoute' => route('employees.create'),
                    'placeholder' => __('translation.SearchEmployee'),
                    'btn' => __('translation.addNewEmployee'),
                    'exportRoute' => route('employees.export'),
                    'fileName' => __('translation.employees_report'),
                ])
                <div class="card-body-table">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('translation.document_number') }}</th>
                                            <th>{{ __('translation.name_nationality') }}</th>
                                            @if (auth()->user()->is_admin())
                                                <th>{{ __('translation.employee_permissions') }}</th>
                                                <th>{{ __('translation.employee_status') }}</th>
                                            @endif
                                            <th>{{ __('translation.created_at') }}</th>
                                            <th></th>
                                            {{-- <th>{{ __('translation.delete') }}</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @include('components.datatable.table', [
                                            'data' => $employees,
                                            'route' => 'employees',
                                            'hasDelete' => false,
                                            'customColumns' => 'employees',
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
