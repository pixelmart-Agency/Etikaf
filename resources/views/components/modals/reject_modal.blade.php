<div id="request-denied" class="modal fade" role="dialog" aria-modal="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content modal-md border-0 py-5 px-3 px-md-4 px-lg-5">
            <div class="modal-header border-0 flex-column align-items-center py-0 mb-4">
                <div class="img-cont mb-4">
                    <img src="{{ assetUrl('img_v2/img-request-denied.png') }}" class="w-100 mw-100" alt="">
                </div>
                <h2 class="block-title mb-2 fs-24"> {{ __('translation.reject_request') }}</h2>
                <div class="block-text fs-18">
                    <p>{{ __('translation.confirm_alert') }}</p>
                </div>
            </div>
            <div class="modal-body py-0">
                <form action="{{ $route }}" method="POST">
                    @csrf
                    <div class="form-group mb-40">
                        <label class="mb-2 text-blue fw-medium">{{ __('translation.reject_reason') }}</label>
                        <select class="select form-select" aria-label="Default select example" name="reason_id">
                            <option value="">{{ __('translation.choose_reject_reason') }}</option>
                            @foreach ($rejectionReasons as $reason)
                                <option value="{{ $reason->id }}">{{ getTransValue($reason->title) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="btn-cont gap-2 justify-content-center">
                        <button type="button" class="main-btn text-blue bg-main-color close"
                            data-dismiss="modal">{{ __('translation.Cancel') }}</button>
                        <button type="submit" class="main-btn bg-gold"> {{ __('translation.reject') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
