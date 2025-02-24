  <div id="request-accept" class="modal fade" role="dialog" aria-modal="true" style="display: none;">
      <div class="modal-dialog">
          <div class="modal-content modal-md border-0 py-5 px-3 px-md-4 px-lg-5">
              <div class="modal-header border-0 flex-column align-items-center py-0 mb-4">
                  <div class="img-cont mb-4">
                      <img src="{{ assetUrl('img_v2/img-request-denied.png') }}" alt="logo" class="img-fluid">
                  </div>
                  <h2 class="block-title mb-2 fs-24">{{ __('translation.confirm_request') }}</h2>
                  <div class="block-text fs-18">
                      <p>{{ __('translation.confirm_alert') }}</p>
                  </div>
              </div>
              <div class="modal-body py-0">
                  <form action="{{ $route }}" method="POST">
                      @csrf
                      <div class="form-group">
                          <label class="sr-only">{{ __('translation.yes_agree') }}</label>
                      </div>
                      <div class="btn-cont gap-2 justify-content-center">
                          <button type="button" class="main-btn text-blue bg-main-color close"
                              data-dismiss="modal">{{ __('translation.Cancel') }}</button>
                          <button type="submit"
                              class="main-btn bg-gold">{{ __('translation.accept_request') }}</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
