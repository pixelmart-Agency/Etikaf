<div class="row layout-cols">
    @if (!route_is('root'))
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="dash-widget d-flex gap-3 flex-column justify-content-between">
                <span class="dash-widget-bg dash-widget-bg1"></span>
                <h3 class="block-subtitle fs-16 fw-normal mb-0 text-green"> {{ __('translation.new_requests') }} </h3>
                <h3 class="block-subtitle fs-30 fw-medium mb-0 text-green">{{ $newRequests }}</h3>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="dash-widget d-flex gap-3 flex-column justify-content-between">
                <span class="dash-widget-bg dash-widget-bg2"></span>
                <h3 class="block-subtitle fs-16 fw-normal mb-0 text-brown"> {{ __('translation.requests_aproved') }}
                </h3>
                <h3 class="block-subtitle fs-30 fw-medium mb-0 text-brown">{{ $approvedRequests }}</h3>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="dash-widget d-flex gap-3 flex-column justify-content-between">
                <span class="dash-widget-bg dash-widget-bg3"></span>
                <h3 class="block-subtitle fs-16 fw-normal mb-0 text-green-1e">{{ __('translation.completed_requests') }}
                </h3>
                <h3 class="block-subtitle fs-30 fw-medium mb-0 text-green-1e">{{ $completedRequests }}</h3>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="dash-widget d-flex gap-3 flex-column justify-content-between">
                <span class="dash-widget-bg dash-widget-bg4"></span>
                <h3 class="block-subtitle fs-16 fw-normal mb-0 text-red-f5">{{ __('translation.canceled_requests') }}
                </h3>
                <h3 class="block-subtitle fs-30 fw-medium mb-0 text-red-f5">{{ $canceledRequests + $rejectedRequests }}
                </h3>
            </div>
        </div>
    @endif
    @if (route_is('root'))
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="dash-widget d-flex gap-3 flex-column justify-content-between">
                <span class="dash-widget-bg dash-widget-bg1"
                    style="background: url('{{ assetUrl('img_v2/tap-employees-icon.svg') }}') no-repeat center center;">
                </span>
                <h3 class="block-subtitle fs-16 fw-normal mb-0 text-green-f5 ">{{ __('translation.Users') }} </h3>
                <h3 class="block-subtitle fs-30 fw-medium mb-0 text-green-f5">{{ $usersCount }}
                </h3>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="dash-widget d-flex gap-3 flex-column justify-content-between">
                <span class="dash-widget-bg dash-widget-bg1"
                    style="background: url('{{ assetUrl('img_v2/tap-employees-icon.svg') }}') no-repeat center center;">
                </span>
                <h3 class="block-subtitle fs-16 fw-normal mb-0 text-green-f5">{{ __('translation.employees') }} </h3>
                <h3 class="block-subtitle fs-30 fw-medium mb-0 text-green-f5">{{ $employeesCount }}
                </h3>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="dash-widget d-flex gap-3 flex-column justify-content-between">
                <span class="dash-widget-bg dash-widget-bg1"
                    style="background: url('{{ assetUrl('img_v2/tap-service-icon.svg') }}') no-repeat center center;">
                </span>
                <h3 class="block-subtitle fs-16 fw-normal mb-0 text-green-f5">{{ __('translation.services_count') }}
                </h3>
                <h3 class="block-subtitle fs-30 fw-medium mb-0 text-green-f5">{{ $servicesCount }}
                </h3>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="dash-widget d-flex gap-3 flex-column justify-content-between">
                <span class="dash-widget-bg dash-widget-bg1"
                    style="background: url('{{ assetUrl('img_v2/tap-digital-icon.svg') }}') no-repeat center center;">
                </span>
                <h3 class="block-subtitle fs-16 fw-normal mb-0 text-green-f5">{{ __('translation.surveys_count') }}
                </h3>
                <h3 class="block-subtitle fs-30 fw-medium mb-0 text-green-f5">{{ $surveysCount }}
                </h3>
            </div>
        </div>
    @endif
</div>
