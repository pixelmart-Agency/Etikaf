@extends('layouts.master')

@section('title')
    @lang('translation.retreat_service_requests') - #{{ $request->id }}
@endsection

@section('content')
    @include('components.breadcrumb', [
        'parent_route' => 'retreat-service-requests.index',
        'parent_title' => __('translation.retreat_service_requests'),
        'title' => __('translation.retreat_service_requests') . ' - ' . $request->id,
    ])
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-lg-7 col-xl-8">
                <div class="card-bg px-4">
                    <div class="text-head d-flex flex-wrap justify-content-between gap-3">
                        <div class="text-cont-right d-flex gap-3">
                            <div class="img-cont img-placeholder">
                                @if (isset($request->retreatRequest?->user?->avatar))
                                    <img src="{{ $request->retreatRequest?->user?->avatar }}"
                                        class="w-100 mw-100 rounded-circle" alt="">
                                @else
                                    <img src="{{ default_avatar() }}" class="w-100 mw-100 rounded-circle" alt="">
                                @endif
                            </div>
                            <div>
                                <h3 class="block-subtitle fs-14 text-light-blue-92">
                                    {{ __('translation.national_id_passport') }}</h3>
                                <h2 class="block-title fs-20 mb-0 text-break">
                                    {{ $request->retreatRequest?->document_number }}</h2>
                            </div>
                        </div>
                        <div class="text-cont-left">
                            <span class="{{ $request->retreatRequest?->status_class }}">
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
                                        <p>
                                            #{{ $request->id }}
                                        </p>
                                    </td>
                                    <td>
                                        <span>{{ __('translation.name') }}</span>
                                        <p>{{ $request->retreatRequest?->user?->name }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span>{{ __('translation.retreat_service_type') }}</span>
                                        <p>{{ getTransValue($request->retreatService?->name) }}</p>
                                    </td>
                                    <td>
                                        <span> {{ __('translation.user_phone') }}</span>
                                        <p>{{ $request->retreatRequest?->user?->mobile }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span>{{ __('translation.nationality') }}</span>
                                        <p>{{ getTransValue($request->retreatRequest?->user?->country?->name) }}</p>
                                    </td>
                                    <td>
                                        <span> {{ __('translation.retreat_date') }}</span>
                                        <p>{{ $request->retreatRequest?->start_time_arabic }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span>{{ __('translation.mosque') }}</span>
                                        <p>{{ getTransValue($request->retreatRequest?->retreatMosque?->name) }}</p>
                                    </td>
                                    <td>
                                        <span> {{ __('translation.mosque_location') }}</span>
                                        <p>{{ $request->retreatRequest?->retreatMosqueLocation?->location }}</p>
                                    </td>
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
                                'location' => $request->retreatRequest?->retreatMosqueLocation?->location,
                                'height' => '100%',
                            ])
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-auto">
            @if (
                $request->retreatRequest?->status == App\Enums\ProgressStatusEnum::APPROVED->value &&
                    $request->status != App\Enums\ProgressStatusEnum::COMPLETED->value)
                <div class="col-12">
                    <div class="text-cont card-bg px-4 py-3">
                        <div class="btn-cont justify-content-end gap-3">
                            <button type="button" class="main-btn border py-10 text-blue bg-transparent"
                                data-toggle="modal"
                                data-target="#reassign-submission">{{ __('translation.reassign') }}</button>

                            <a href="#" data-toggle="modal" data-target="#confirm-request-service" class="main-btn">تم
                                تنفيذ الطلب</a>
                        </div>
                    </div>
                </div>
        </div>
        @include('components.modals.reassign_employee')
        @include('components.modals.common_modal', [
            'id' => 'confirm-request-service',
            'confirm_title' => __('translation.complete_request'),
            'confirm_message' => __('translation.confirm_alert'),
            'route' => route('retreat-service-requests.accept', $request->id),
        ])
        @endif
    @endsection
    @section('script')
    @endsection
