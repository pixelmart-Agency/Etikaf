@extends('layouts.master')

@section('title')
    @lang('translation.retreat_requests')
@endsection
@section('content')
    <input type="hidden" id="export-route" value="{{ route('retreat-requests.export') }}">
    <input type="hidden" id="file-name" value="{{ __('translation.retreat_requests_report') }}">
    @include('components.request_components.states', [
        'newRequests' => $newRequests,
        'approvedRequests' => $approvedRequests,
        'completedRequests' => $completedRequests,
        'canceledRequests' => $canceledRequests,
    ])
    @include('components.request_components.request_status')
    @include('components.request_components.request_data')
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
            $('.rejectAll-btn').on('click', function(e) {
                e.preventDefault();
                let selectedIds = $(".select-box:checked").map(function() {
                    return this.value;
                }).get();

                $.ajax({
                    url: '{{ route('retreat-requests.reject') }}',
                    method: 'POST',
                    data: {
                        selectedIds: selectedIds,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        console.log(data);
                        window.location.reload();

                    },
                    error: function(err) {
                        console.error('Error rejecting request:', err);
                        alert('Error rejecting request');
                    }
                });
            });
            $('.acceptAll-btn').on('click', function(e) {
                e.preventDefault();
                let selectedIds = $(".select-box:checked").map(function() {
                    return this.value;
                }).get();

                $.ajax({
                    url: '{{ route('retreat-requests.accept') }}',
                    method: 'POST',
                    data: {
                        selectedIds: selectedIds,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        window.location.reload();
                        console.log(data);
                    }
                });
            });
        });
        // Here, send `selectedIds` to the backend via AJAX or form submission
    </script>
@endsection
