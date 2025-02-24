  <div class="row">
      <div class="col-12">
          <div class="card-bg d-flex align-items-center justify-content-between px-4">
              <div
                  class="text-cont flex-grow-1 gap-3 flex-shrink-0 d-flex flex-wrap justify-content-between align-items-start">
                  <div>
                      <h2 class="block-title">{{ __('translation.retreat_season_status') }}</h2>
                      <div class="block-text">
                          <p>{{ __('translation.open_time') }} :
                              @if (currentSeason())
                                  <span> {{ convertToHijri(currentSeason()->start_date) }}</span>
                              @else
                                  <span> {{ __('translation.not_set_yet') }}</span>
                              @endif
                          </p>
                      </div>
                  </div>
                  @if (retreat_season_is_open())
                      <h3 class="block-subtitle fs-14 rounded-pill py-1 px-3 mb-0 text-green bg-light-green">
                          {{ __('translation.season_open') }}</h3>
                  @else
                      <h3 class="block-subtitle fs-14 rounded-pill py-1 px-3 mb-0 text-red bg-light-red">
                          {{ __('translation.season_closed') }}</h3>
                  @endif
              </div>
              @if (retreat_season_is_open())
                  <div class="reschedule-closing-date flex-grow-1">
                      <div class="btn-cont justify-content-end">
                          @if (auth()->user()->hasPermissionTo('retreat_requests'))
                              <a href="" class="secondary-btn" data-toggle="modal"
                                  data-target="#close-submission">
                                  {{ __('translation.close_submission') }}
                              </a>
                              <a href="#" data-toggle="modal" data-target="#request-createSurvey"
                                  class="main-btn bg-red-f5">{{ __('translation.close_now') }}</a>
                          @endif
                      </div>
              @endif
          </div>
      </div>
  </div>
  @include('components.modals.common_modal', [
      'confirm_title' => __('translation.Are you sure you want to close the season?'),
      'confirm_message' => $confirm_message ?? '',
      'route' => route('close_season'),
  ])
