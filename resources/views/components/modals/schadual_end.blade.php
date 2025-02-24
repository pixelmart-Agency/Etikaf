<div id="close-submission" class="modal fade" role="dialog" aria-modal="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content modal-md">
            <div class="modal-header flex-column align-items-start">
                <h2 class="block-title fs-20 mb-1">{{ __('translation.close_submission') }}</h2>
                <div class="block-text fs-18">
                    <p>{{ __('translation.choose_close_time') }}</p>
                </div>
            </div>
            <div class="modal-body p-0">
                <form action="{{ route('schaduale_close_season') }}" method="post">
                    @csrf
                    <div class="form-group p-4">
                        <label class="fs-16 fw-medium mb-2">{{ __('translation.close_submission_time') }}</label>
                        <div class="cal-icon">
                            <input class="form-control datetimepicker" type="text" name="end_date"
                                format="YYYY-MM-DD" placeholder="{{ __('translation.choose_time') }}">
                        </div>
                    </div>
                    <div class="btn-cont justify-content-between px-4 pb-4">
                        <button type="button" class="main-btn text-blue bg-main-color close"
                            data-dismiss="modal">{{ __('translation.Cancel') }}</button>
                        <button type="submit" class="main-btn bg-gold">{{ __('translation.approve_time') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
