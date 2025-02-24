@extends('layouts.master')

@section('title')
    @lang('translation.retreat_requests') - #{{ $request->id }}
@endsection

@section('content')
    @include('components.breadcrumb', [
        'parent_route' => 'retreat_requests.index',
        'parent_title' => __('translation.retreat_requests'),
        'title' => __('translation.retreat_requests') . ' - ' . $request->id,
    ])
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-lg-7 col-xl-8">
                <div class="card-bg px-4">
                    <div class="text-head d-flex flex-wrap justify-content-between gap-3">
                        <div class="text-cont-right d-flex gap-3">
                            <div class="img-cont img-placeholder">
                                @if (isset($request->user) && $request->user->avatar)
                                    <img src="{{ $request->user->avatar }}" class="w-100 mw-100 rounded-circle" alt="">
                                @else
                                    <img src="{{ default_avatar() }}" class="w-100 mw-100 rounded-circle" alt="">
                                @endif
                            </div>
                            <div>
                                <h3 class="block-subtitle fs-14 text-light-blue-92">
                                    {{ __('translation.national_id_passport') }}</h3>
                                <h2 class="block-title fs-20 mb-0 text-break">{{ $request->document_number }}</h2>
                            </div>
                        </div>
                        <div class="text-cont-left">
                            <span class="{{ $request->status_class }}">
                                <span>{{ __('translation.' . $request->status) }}</span>
                            </span>
                        </div>
                    </div>
                    <div class="text-body">
                        <table class="basic-table">
                            <tbody>
                                <tr>
                                    <td>
                                        <span> {{ __('translation.request_number') }}</span>
                                        <p>#{{ $request->id }}</p>
                                    </td>
                                    <td>
                                        <span>{{ __('translation.name') }}</span>
                                        <p>{{ $request->name ?? $request->user->name }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span>{{ __('translation.nationality') }}</span>
                                        <p>{{ getTransValue($request->user?->country?->name) }}</p>
                                    </td>
                                    <td>
                                        <span> {{ __('translation.request_date') }}</span>
                                        <p>{{ $request->start_time_arabic }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span>{{ __('translation.request_mosque') }}</span>
                                        <p>{{ getTransValue($request->retreatMosque?->name) }}</p>
                                    </td>
                                    <td>
                                        <span> {{ __('translation.request_mosque_location') }}</span>
                                        <p>{{ getTransValue($request->retreatMosqueLocation?->name) }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span>{{ __('translation.request_age') }}</span>
                                        <p>{{ $request->user?->age }}</p>
                                    </td>
                                    <td>
                                        <span> {{ __('translation.user_phone') }}</span>
                                        <p>{{ $request->user?->mobile }}</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <span>{{ __('translation.birthday') }}</span>
                                        <p>{{ $request->user?->birthday }}</p>
                                    </td>
                                    @if ($request->user?->app_user_type)
                                        <td>
                                            <span> {{ __('translation.app_user_type') }}</span>
                                            <p>{{ __('translation.' . $request->user?->app_user_type) }}</p>
                                        </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>
                                        <span>{{ __('translation.status') }}</span>
                                        <p>{{ __('translation.' . $request->status) }}</p>
                                    </td>
                                    @if ($request->status == App\Enums\ProgressStatusEnum::REJECTED->value)
                                        <td>
                                            <span>{{ __('translation.reject_reason') }}</span>
                                            <p>{{ isset($request->rejectReasonObject) ? getTransValue($request->rejectReasonObject?->title) : __('translation.no_reason_specified') }}
                                            </p>
                                        </td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5 col-xl-4 d-flex flex-column">
                <div class="card-bg px-4 mb-4 flex-grow-1">
                    <h3 class="block-subtitle mb-3 text-blue fw-medium">{{ __('translation.map') }}</h3>
                    <div class="card-map">
                        <div class="img-cont rounded-3">
                            @include('components.inputs.map', [
                                'location' => $request->retreatMosqueLocation?->location,
                                'height' => '100%',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-bg p-4 flex-grow-1">
                    <h4 class="block-subtitle mb-30 fw-medium fs-16 text-blue"> {{ __('translation.place_details') }}
                    </h4>
                    <div class="d-flex flex-wrap justify-content-between">
                        <div>
                            <span class="text-light-blue-92 fs-14">{{ __('translation.place_location') }}</span>
                            <h4 class="block-subtitle mb-0 mt-3 fw-medium fs-16 text-blue">
                                {{ getTransValue($request->retreatMosqueLocation?->name) }} </h4>
                        </div>
                        {!! $request->retreatMosqueLocation?->request_status !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($request->status == App\Enums\ProgressStatusEnum::PENDING->value)
        <div class="col-12">
            <div class="row mt-50">
                <div class="col-12">
                    <div class="text-cont card-bg px-4 py-3">
                        <div class="btn-cont justify-content-end gap-3">
                            <a href="#" class="main-btn text-red bg-light-red" data-toggle="modal"
                                data-target="#request-denied">{{ __('translation.reject') }}</a>

                            <a href="#" class="main-btn" data-toggle="modal" data-target="#request-accept">
                                {{ __('translation.accept_request') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @include('components.modals.confirm_modal', [
        'route' => route('retreat_requests.accept', $request->id),
    ])
    @include('components.modals.reject_modal', [
        'rejectionReasons' => $rejectionReasons,
        'route' => route('retreat_requests.reject', $request->id),
    ])
@endsection
@section('script')
@endsection
