@extends('layouts.master')

@section('title')
    @lang('translation.retreat_service_requests')
@endsection
@section('content')
    <div class="row row-main-order">
        <div class="col-12">
            <div class="card-bg px-4">
                <div class="filter-row d-flex flex-wrap align-items-center gap-2 justify-content-between mb-2">
                    <div class="text-cont">
                        <h2 class="block-title"> {{ __('translation.retreat_service_requests') }} </h2>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <fieldset class="position-relative">
                            <legend class="sr-only">Search input</legend>
                            <input type="search" class="form-control" id="inputSearchTable" autocomplete="off"
                                placeholder="{{ __('translation.filter_with_national_passport') }}"
                                aria-label="Search input" name="inputSearchTable">
                            <i class="icon-search-i position-absolute top-50 translate-middle-y ms-3"></i>
                        </fieldset>
                        <div class="form-group form-focus select-focus mb-0">
                            <select class="select floating" id="selectFilterTable">
                                <option value="">{{ __('translation.request_status') }}</option>
                                @foreach (App\Enums\ProgressStatusEnum::cases() as $status)
                                    <option value="{{ __('translation.' . $status->value) }}">
                                        {{ __('translation.' . $status->value) }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                        <button type="submit" class="btn-submit" id="submitFilterTable"></button>
                        <button type="button" class="custom-popovers" id="btnExportTable" data-content="تصدير"></button>
                        {{-- <div class="d-flex gap-2 flex-wrap">
                            <button type="button" class="rejectAll-req main-btn fs-14 px-4 bg-light-red text-red" disabled>
                                {{ __('translation.reject') }}
                            </button>
                            <button type="button" class="acceptAll-req main-btn fs-14 px-4" disabled>
                                {{ __('translation.accept_request') }}
                            </button>
                        </div> --}}
                    </div>
                </div>
                <input type="hidden" id="export-route" value="{{ route('retreat-service-requests.export') }}">
                <input type="hidden" id="file-name" value="{{ __('translation.retreat_service_requests_report') }}">

                @if (retreat_season_is_open())
                    @if ($requests->count() == 0)
                        <div class="card-body-table">
                            <div class="card-body-default d-flex flex-column align-items-center mt-5">
                                <div class="img-cont mb-30">
                                    <img src="{{ assetUrl('img_v2/default-img-order.png') }}" alt="retreat-img">
                                </div>
                                <h2>{{ __('translation.no_requests') }}</h2>

                            </div>
                        </div>
                    @else
                        <div class="card-body-table">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped custom-table mb-0 datatable">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        {{-- <span class="position-absolute top-50 translate-middle-y">
                                                            <label class="lable-select-box">
                                                                <input type="checkbox" id="selectAll"
                                                                    aria-label="Select all">
                                                            </label>
                                                        </span> --}}
                                                        #
                                                    </th>
                                                    <th>{{ __('translation.national_id_passport') }}</th>
                                                    <th>{{ __('translation.name_nationality') }}</th>
                                                    <th>{{ __('translation.retreat_service_type') }}</th>
                                                    <th>{{ __('translation.mosque') }}</th>
                                                    <th>{{ __('translation.mosque_location') }}</th>
                                                    <th>{{ __('translation.retreat_request_date') }}</th>
                                                    <th>{{ __('translation.status') }}</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($requests as $request)
                                                    <tr>
                                                        <td>
                                                            {{-- <label class="lable-select-box">
                                                                <input type="checkbox" class="select-box"
                                                                    name="selectedIds[]" value="{{ $request->id }}">
                                                            </label> --}}
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td>{{ $request->retreatRequest?->user?->document_number }}</td>
                                                        <td>
                                                            <h2><a
                                                                    href="{{ route('users.edit', $request->retreatRequest?->user?->id) }}">
                                                                    {{ $request->retreatRequest?->name }}
                                                                    <span>{{ getTransValue($request->retreatRequest?->user?->country?->name) }}</span>
                                                            </h2>
                                                        </td>
                                                        <td> {{ getTransValue($request->retreatService?->name) }}
                                                        <td> {{ getTransValue($request->retreatRequest?->retreatMosque?->name) }}
                                                        </td>
                                                        <td> {{ getTransValue($request->retreatRequest?->retreatMosqueLocation?->name) }}
                                                        <td>{{ $request->retreatRequest?->start_time_arabic }}
                                                        </td>
                                                        <td class="{{ $request->status_class }}">
                                                            <span>{{ __('translation.' . $request->status) }}</span>
                                                        <td class="show-td"><a
                                                                href="{{ route('retreat-service-requests.show', $request->id) }}"><i
                                                                    aria-hidden="true"></i>
                                                                {{ __('translation.view') }}</a></td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="card-body-table">
                        <div class="card-body-default d-flex flex-column align-items-center mt-5">
                            <div class="img-cont mb-30">
                                <img src="{{ assetUrl('img_v2/default-img-order.png') }}" alt="retreat-img">
                            </div>
                            <h2>{{ __('translation.no_requests') }}</h2>

                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        let arrayDisabled = 0;
        let rejectAll = $(".rejectAll-req");
        let acceptAll = $(".acceptAll-req");
        // Select All Checkbox
        function btnStatusDisabled(boolean) {
            rejectAll.prop("disabled", boolean);
            acceptAll.prop("disabled", boolean);
        }
        $("input[type='checkbox']#selectAll").on("click", function() {
            $("input[type='checkbox'].select-box").prop("checked", this.checked);

            if ($(this).prop("checked")) {
                btnStatusDisabled(false)
                arrayDisabled = $(".select-box:checked").length;
            } else {
                btnStatusDisabled(true)
                arrayDisabled = 0;
            }

        });

        // Uncheck "Select All" if any checkbox is unchecked
        $("input[type='checkbox'].select-box").on("click", function() {
            $("input[type='checkbox']#selectAll").prop("checked", $(".select-box:checked").length === $(
                "input[type='checkbox'].select-box").length);
            $(this).prop("checked") ? arrayDisabled += 1 : arrayDisabled -= 1;
            arrayDisabled > 0 ? btnStatusDisabled(false) : btnStatusDisabled(true);
        });

        // Request Rejection Form with Selected IDs
        rejectAll.on("click", function(e) {
            e.preventDefault();
            let selectedIds = $(".select-box:checked").map(function() {
                return this.value;
            }).get();

            console.log("Rejection IDs:", selectedIds);
            // Here, send `selectedIds` to the backend via AJAX or form submission
        });

        // Request Accept Form with Selected IDs
        acceptAll.on("click", function(e) {
            e.preventDefault();
            let selectedIds = $(".select-box:checked").map(function() {
                return this.value;
            }).get();

            console.log("Accept IDs:", selectedIds);
            // Here, send `selectedIds` to the backend via AJAX or form submission
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.rejectAll-req').on('click', function(e) {
                e.preventDefault();
                let selectedIds = $(".select-box:checked").map(function() {
                    return this.value;
                }).get();

                $.ajax({
                    url: '{{ route('retreat-service-requests.rejects') }}',
                    method: 'POST',
                    data: {
                        selectedIds: selectedIds,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        console.log(data);
                        // window.location.reload();

                    }
                });
            });
            $('.acceptAll-req').on('click', function(e) {
                e.preventDefault();
                let selectedIds = $(".select-box:checked").map(function() {
                    return this.value;
                }).get();

                $.ajax({
                    url: '{{ route('retreat-service-requests.accepts') }}',
                    method: 'POST',
                    data: {
                        selectedIds: selectedIds,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        // window.location.reload();
                        console.log(data);
                    }
                });
            });
        });
        // Here, send `selectedIds` to the backend via AJAX or form submission
    </script>
@endsection
