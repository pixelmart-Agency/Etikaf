<?php

namespace App\Http\Controllers\Api;

use App\Actions\ChangeRequestServiceStatusAction;
use App\Actions\ChangeTreatRequestStatusAction;
use App\Data\RetreatRequestData;
use App\Enums\ProgressStatusEnum;
use App\Enums\RetreatSeasonStatusEnum;
use App\Enums\UserTypesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\RetreatRequestRequest;
use App\Http\Resources\RetreatMosqueLocationResource;
use App\Http\Resources\RetreatMosqueResource;
use App\Http\Resources\RetreatRequestResource;
use App\Http\Resources\RetreatSeasonResource;
use App\Models\RetreatRequest;
use App\Models\RetreatRequestServiceModel;
use App\Models\RetreatSeason;
use App\Notifications\RetreatRequestCreatedNotification;
use App\Responses\ErrorResponse;
use App\Responses\SuccessResponse;
use App\Services\RetreatRequestService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class RetreatRequestController extends Controller
{
    protected $retreatRequestService;
    public function __construct(RetreatRequestService $retreatRequestService)
    {
        $this->retreatRequestService = $retreatRequestService;
    }
    public function create(RetreatRequestRequest $request)
    {
        $retreatSeason = currentSeason();
        if (!$retreatSeason) {
            return ErrorResponse::send(__('translation.retreat_season_not_started'), 400);
        }
        $retreatRequest = RetreatRequest::where('retreat_season_id', $retreatSeason->id)
            ->where('user_id', Auth::id())
            ->whereNotIn('status', [ProgressStatusEnum::CANCELLED->value, ProgressStatusEnum::REJECTED->value])
            ->first();
        if ($retreatRequest) {
            return ErrorResponse::send(__('translation.retreat_request_already_exists'), 400);
        }
        try {
            $validatedData = $request->validated();
            $validatedData['user_id'] = Auth::id();
            $validatedData['name'] = request()->get('name') ?? Auth::user()->name;
            $validatedData['document_number'] = request()->get('document_number') ?? Auth::user()->document_number;
            $validatedData['birthday'] = request()->get('birthday') ?? Auth::user()->birthday;
            $validatedData['phone'] = request()->get('phone') ?? Auth::user()->phone;
            $validatedData['status'] = ProgressStatusEnum::PENDING->value;
            $validatedData['retreat_season_id'] = $retreatSeason->id;
            $validatedData = RetreatRequestData::fromArray($validatedData);
            $retreatRequest = $this->retreatRequestService->createRetreatRequest($validatedData);
            $retreatRequest = $retreatRequest->eagerLoadData()->find($retreatRequest->id);

            $retreatRequest->refresh();
            return SuccessResponse::send(RetreatRequestResource::make($retreatRequest), __('translation.retreat_request_created'), 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ErrorResponse::send($e->getMessage(), 500);
        }
    }
    public function getRetreatMosques(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $retreatMosques = $this->retreatRequestService->getRetreatMosques($perPage);
        return SuccessResponse::send(RetreatMosqueResource::collection($retreatMosques), __('translation.retreat_mosques_found'), 200, true);
    }
    public function getRetreatMosqueLocations(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $retreatMosqueLocations = $this->retreatRequestService->getRetreatMosqueLocations($perPage);
        return SuccessResponse::send(RetreatMosqueLocationResource::collection($retreatMosqueLocations), __('translation.retreat_mosque_locations_found'), 200, true);
    }
    public function changeRequestStatus(Request $request, RetreatRequest $retreatRequest, ChangeTreatRequestStatusAction $changeTreatRequestStatusAction)
    {
        $request->validate([
            'status' => ['required', 'string', Rule::in(ProgressStatusEnum::cases())],
        ]);
        if ($retreatRequest->status === $request->status) {
            return SuccessResponse::send(0, __('translation.cannot_change_status'), 400);
        }
        if ($retreatRequest->status === ProgressStatusEnum::CANCELLED->value && Auth::user()->id !== $retreatRequest->user->id) {
            return ErrorResponse::send(__('translation.cannot_cancel_request'), 400);
        }
        if (
            $retreatRequest->status == ProgressStatusEnum::PENDING &&
            in_array($request->status, array(ProgressStatusEnum::COMPLETED->value))
        ) {
            return ErrorResponse::send(__('translation.cannot_complete_yet'), 400);
        }
        $changeTreatRequestStatusAction->execute($retreatRequest, $request->status);
        return SuccessResponse::send(1, __('translation.request_status_changed'), 200);
    }
    public function changeRequestServiceStatus(
        Request $request,
        RetreatRequestServiceModel $retreatRequestServiceModel,
        ChangeRequestServiceStatusAction $changeRequestServiceStatusAction
    ) {
        $request->validate([
            'status' => ['required', 'string', Rule::in(ProgressStatusEnum::cases())],
        ], [
            'status.required' => __('translation.send_at_least_one_service'),
        ]);
        if ($retreatRequestServiceModel->status === $request->status) {
            return SuccessResponse::send(0, __('translation.cannot_change_status'), 400);
        }
        if ($request->status === ProgressStatusEnum::IN_PROGRESS->value && Auth::user()->user_type !== UserTypesEnum::EMPLOYEE->value) {
            return ErrorResponse::send(__('translation.cannot_change_status'), 400);
        }
        if (
            $retreatRequestServiceModel->status == ProgressStatusEnum::PENDING &&
            in_array($request->status, array(ProgressStatusEnum::COMPLETED->value))
        ) {
            return ErrorResponse::send(__('translation.cannot_complete_yet'), 400);
        }
        if ($request->status === ProgressStatusEnum::COMPLETED->value && $retreatRequestServiceModel->employee_id !== Auth::id()) {
            return ErrorResponse::send(__('translation.request_service_not_yours'), 400);
        }
        try {
            $changeRequestServiceStatusAction->execute($retreatRequestServiceModel, $request->status, Auth::user()->id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ErrorResponse::send($e->getMessage(), 500);
        }
        return SuccessResponse::send(1, __('translation.request_status_changed'), 200);
    }
    public function getCurrentRetreatSeason()
    {
        $retreatSeason = currentSeason();
        if (!$retreatSeason) {
            return ErrorResponse::send(__('translation.season_not_found'), 400);
        }
        return SuccessResponse::send(RetreatSeasonResource::make($retreatSeason), __('translation.retreat_season_found'), 200);
    }
    public function requestRetreatServices(Request $request)
    {
        $user = Auth::user();
        $retreatRequest = $user->current_retreat_request;
        if (!$retreatRequest) {
            return ErrorResponse::send(__('translation.retreat_request_not_found'), 400);
        }
        $request->validate(
            [
                'service_ids' => ['required', 'array'],
                'service_ids.*' => ['required', 'exists:retreat_services,id'],
            ],
            [
                'service_ids.required' => __('translation.send_at_least_one_service'),
                'service_ids.*' => __('translation.retreat_service_not_found'),
            ]
        );
        if ($retreatRequest->status !== ProgressStatusEnum::APPROVED->value) {
            return ErrorResponse::send(__('translation.retreat_request_not_approved'), 400);
        }

        if ($retreatRequest->user->id !== Auth::id()) {
            return ErrorResponse::send(__('translation.retreat_request_not_yours'), 400);
        }


        $retreatRequest = $this->retreatRequestService->requestRetreatService($retreatRequest, $request->service_ids);


        $retreatRequest = $retreatRequest->eagerLoadData()->find($retreatRequest->id);

        $retreatRequest->refresh();

        return SuccessResponse::send(RetreatRequestResource::make($retreatRequest), __('translation.retreat_request_created'), 200);
    }
    public function getRetreatRequestLocation()
    {
        $user = Auth::user();
        $retreatRequest = $user->current_retreat_request;
        if (!$retreatRequest) {
            return ErrorResponse::send(__('translation.request_not_found'), 404);
        }
        $retreatRequestLocation = $this->retreatRequestService->getRetreatRequestLocation($retreatRequest);
        $location = null;
        if ($retreatRequestLocation && $retreatRequestLocation->location) {
            $location = new \stdClass();
            $location->lat = explode(',', $retreatRequestLocation->location)[0];
            $location->lng = explode(',', $retreatRequestLocation->location)[1];
        }
        $response = array(
            'lat' => $location->lat,
            'lng' => $location->lng,
            'image_url' => $retreatRequestLocation->image_url,
        );
        return SuccessResponse::send($response, __('translation.retreat_request_location_found'), 200);
    }
    public function getQrCode()
    {
        $retreatRequest = Auth::user()->current_retreat_request;
        if (!$retreatRequest)
            return ErrorResponse::send(__('translation.no_request'), 400);
        if ($retreatRequest->status != ProgressStatusEnum::APPROVED->value)
            return ErrorResponse::send(__('translation.request_not_approved'), 400);

        $qrCode = $this->retreatRequestService->getQrCode($retreatRequest);
        return SuccessResponse::send($qrCode, __('translation.qr_code'), 200);
    }
    public function checkQrCode(Request $request)
    {
        $request->validate(
            [
                'request_id' => ['required', 'exists:retreat_requests,id'],
            ],
            [
                'request_id.required' => __('translation.request_id_required'),
                'request_id.exists' => __('translation.qr_code_not_found'),
            ]
        );
        $qrCode = $this->retreatRequestService->checkQrCode($request->request_id);
        if (!$qrCode)
            return ErrorResponse::send(__('translation.qr_code_not_found'), 400);
        if ($qrCode->is_read)
            return ErrorResponse::send(__('translation.qr_code_already_read'), 400);

        $qrCode->update(['is_read' => true]);
        return SuccessResponse::send(1, __('translation.qr_code_successfully_read'), 200);
    }
}
