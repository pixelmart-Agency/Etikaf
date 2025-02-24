<?php

namespace App\Http\Controllers\Api;

use App\Enums\ProgressStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\OnboardingScreenResource;
use App\Http\Resources\RetreatInstructionResource;
use App\Http\Resources\RetreatRequestServiceEmployeeResource;
use App\Http\Resources\RetreatRequestServiceResource;
use App\Http\Resources\RetreatServiceResource;
use App\Http\Resources\SupportServiceResource;
use App\Models\Reason;
use App\Models\RetreatRequest;
use App\Models\RetreatRequestServiceModel;
use App\Responses\ErrorResponse;
use App\Responses\SuccessResponse;
use App\Services\NafathService;
use App\Services\RetreatRequestService;
use App\Services\RetreatServiceService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AppHomeController extends Controller
{
    protected $retreatServiceService;
    public function __construct(RetreatServiceService $retreatServiceService)
    {
        $this->retreatServiceService = $retreatServiceService;
    }
    public function nafathCallback()
    {
        $nafathService = new NafathService();
        $nafathService->handleCallback(request()->input('response'));
    }
    public function validateNafath(Request $request)
    {
        $request->validate([
            'national_id' => 'required|string',
        ]);
        $nafathService = new NafathService();
        $response = $nafathService->sendLoginRequest($request->national_id);
        return response()->json($response);
    }
    public function index(Request $request)
    {
        $perPage = request()->get('per_page', 10);
        $response = array();
        $user = Auth::user();
        $currentSeason = currentSeason();
        $response['user_request'] = null;
        if ($currentSeason && $currentSeason->start_date <= Carbon::now()->toDateString()) {
            $response['user_request'] = null;
            $userRequest = RetreatRequest::query()->select('id', 'status', 'reason_id')
                ->where('user_id', $user->id)
                ->where('retreat_season_id', $currentSeason->id)
                ->orderBy('id', 'desc')
                ->first();
            if ($userRequest) {
                $userRequest->reject_reason = null;
                $userRequest->reject_reason = null;
                if ($userRequest && $userRequest->status === ProgressStatusEnum::REJECTED->value) {
                    $userRequest->reject_reason = getTransValue($userRequest->rejectReasonObject?->title);
                    unset($userRequest->rejectReasonObject);
                }
                $userRequest->reason_id = intval($userRequest->reason_id);
                // Add the user request to the response
                $response['user_request'] = $userRequest;
            }
        } else {
            $response['user_request'] = new \stdClass();
            $response['user_request']->id = 0;
            $response['user_request']->status = 'closed';
            $response['user_request']->reason_id = 0;
            $response['user_request']->reject_reason = null;
        }

        $response['prayers'] = get_prayer_times();
        $response['retreat_services'] = $this->retreatServiceService->getRetreatServices($perPage)->items();
        $response['retreat_services'] = RetreatServiceResource::collection($response['retreat_services']);
        $response['retreat_instructions'] = $this->retreatServiceService->getRetreatInstructions($perPage)->items();
        $response['retreat_instructions'] = RetreatInstructionResource::collection($response['retreat_instructions']);
        $response['support_services'] = $this->retreatServiceService->getSupportServices($perPage)->items();
        $response['support_services'] = SupportServiceResource::collection($response['support_services']);
        return SuccessResponse::send($response, __('translation.home_index'), 200);
    }
    public function getRateQuestion()
    {
        $response = [];
        $response['rate_question'] = getSetting('rate_question');
        $response['rate_question_title'] = getSetting('rate_question_title');
        return SuccessResponse::send($response, __('translation.rate_question'), 200);
    }
    public function employeeIndex()
    {
        $response = [];
        $response['pending_requests_count'] = $this->retreatServiceService->getRetreatRequestServices(null, ProgressStatusEnum::PENDING->value, true, true, false);
        $response['completed_requests_count'] = $this->retreatServiceService->getRetreatRequestServices(null, ProgressStatusEnum::COMPLETED->value, true, true, false);
        $response['total_requests_count'] = $this->retreatServiceService->getRetreatRequestServices(null, null, true, true, false);
        $response['pending_requests'] = $this->retreatServiceService->getRetreatRequestServices(10, ProgressStatusEnum::PENDING->value, false, true, false);
        $response['pending_requests'] = RetreatRequestServiceResource::collection($response['pending_requests']);
        return SuccessResponse::send($response, __('translation.employee_index'), 200);
    }
    public function prayers()
    {
        $prayers = get_prayer_times();
        if (!$prayers) {
            return ErrorResponse::send(__('translation.prayers_not_found'), 404);
        }
        return SuccessResponse::send($prayers, __('translation.prayers_found'), 200);
    }
    public function retreatServices()
    {
        $perPage = request()->get('per_page', 10);
        $retreatServices = $this->retreatServiceService->getRetreatServices($perPage);
        $retreatServices = RetreatServiceResource::collection($retreatServices);
        return SuccessResponse::send($retreatServices, __('translation.retreat_services_found'), 200, true);
    }
    public function retreatInstructions()
    {
        $perPage = request()->get('per_page', 10);
        $retreatInstructions = $this->retreatServiceService->getRetreatInstructions($perPage);
        $retreatInstructions = RetreatInstructionResource::collection($retreatInstructions);
        return SuccessResponse::send($retreatInstructions, __('translation.retreat_instructions_found'), 200, true);
    }
    public function supportServices()
    {
        $perPage = request()->get('per_page', 10);
        $supportServices = $this->retreatServiceService->getSupportServices($perPage);
        $supportServices = SupportServiceResource::collection($supportServices);
        return SuccessResponse::send($supportServices, __('translation.support_services_found'), 200, true);
    }
    public function inRetreatServices()
    {
        $perPage = request()->get('per_page', 10);
        $is_paginated = request()->get('is_paginated', false);
        $inRetreatServices = $this->retreatServiceService->getRetreatServicesGroupedByCategory($perPage, $is_paginated);
        return SuccessResponse::send($inRetreatServices, __('translation.in_retreat_services_found'), 200);
    }
    public function OnboardingScreens()
    {
        $perPage = request()->get('per_page', 10);
        $OnboardingScreens = $this->retreatServiceService->getOnboardingScreens($perPage);
        $OnboardingScreens = OnboardingScreenResource::collection($OnboardingScreens);
        return SuccessResponse::send($OnboardingScreens, __('translation.onboarding_screens_found'), 200, true);
    }
    public function retreatRequestServices(Request $request)
    {
        $request->validate([
            'status' => ['required', 'string', Rule::in(ProgressStatusEnum::cases())],
        ]);

        $perPage = request()->get('per_page', 10);
        $is_count = request()->get('is_count', false);
        $retreatServices = $this->retreatServiceService->getRetreatRequestServices($perPage, $request->status, $is_count, true);

        if ($is_count) {
            return SuccessResponse::send($retreatServices, __('translation.retreat_request_services_count'), 200);
        }
        $retreatServicesForPagination = $retreatServices;
        $groupedServices = $this->groupServicesByDate($retreatServices);
        $response = [
            'request_services' => $groupedServices,
            'total_count' => $this->retreatServiceService->getRetreatRequestServices(null, $request->status, true, true, false),
            'current_page' => $retreatServicesForPagination->currentPage(),
            'last_page' => $retreatServicesForPagination->lastPage(),
            'per_page' => $retreatServicesForPagination->perPage(),
        ];
        return SuccessResponse::send($response, __('translation.request_services_found'), 200);
    }

    private function groupServicesByDate($services)
    {
        $groupedServices = [];
        $today = Carbon::today()->format('Y-m-d');
        $yesterday = Carbon::yesterday()->format('Y-m-d');

        foreach ($services as $service) {
            $serviceDate = Carbon::parse($service->created_at)->format('Y-m-d');
            $groupKey = $this->getGroupKey($serviceDate, $today, $yesterday);

            if (!isset($groupedServices[$groupKey])) {
                $groupedServices[$groupKey] = [
                    'day' => $groupKey,
                    'services' => []
                ];
            }

            $groupedServices[$groupKey]['services'][] = new RetreatRequestServiceResource($service);
        }

        return array_values($groupedServices);
    }

    private function getGroupKey($serviceDate, $today, $yesterday)
    {
        if ($serviceDate === $today) {
            return __('translation.today');
        } elseif ($serviceDate === $yesterday) {
            return __('translation.yesterday');
        } else {
            return $serviceDate;
        }
    }
    public function getRetreatRequestService(RetreatRequestServiceModel $retreatRequestServiceModel)
    {
        $retreatRequestService = RetreatRequestServiceEmployeeResource::make($retreatRequestServiceModel->load('retreatService'));
        return SuccessResponse::send(RetreatRequestServiceEmployeeResource::make($retreatRequestService), __('translation.retreat_request_service_found'), 200);
    }
}
