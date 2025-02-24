@extends('layouts.master')

@section('title')
    @lang('translation.Dashboard')
@endsection

@section('content')
    <input type="hidden" id="file-name" value="{{ __('translation.retreat_requests_report') }}">
    @include('components.request_components.states', [
        'newRequests' => $newRequests,
        'approvedRequests' => $approvedRequests,
        'completedRequests' => $completedRequests,
        'canceledRequests' => $canceledRequests,
    ])
    @include('components.request_components.request_status')
    @if (auth()->user()->hasPermissionTo('retreat_requests'))
        @include('components.request_components.request_data')
    @endif
@endsection
@section('script')
@endsection
