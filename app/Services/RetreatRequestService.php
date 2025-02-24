<?php

namespace App\Services;

use App\Data\RetreatRequestData;
use App\Enums\ProgressStatusEnum;
use App\Enums\ReasonTypesEnum;
use App\Http\Resources\RequestQrCodeResource;
use App\Models\Reason;
use App\Models\RequestQrCode;
use App\Models\RetreatMosque;
use App\Models\RetreatMosqueLocation;
use App\Models\RetreatRequest;
use App\Notifications\RetreatRequestCreatedNotification;
use App\Notifications\RetreatRequestServicesAddedNotification;
use App\Responses\ErrorResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RetreatRequestService
{
    public function getRetreatRequests($perPage = 10, $extra = [], $is_count = false, $is_paginated = true)
    {
        $retreatRequest = RetreatRequest::query()->filter($extra);
        if ($is_count)
            return $retreatRequest->count();
        if ($is_paginated)
            return $retreatRequest->paginate($perPage);
        else
            return $retreatRequest->get();
    }

    public function createRetreatRequest(RetreatRequestData $data, $inTransaction = true)
    {
        if ($inTransaction) {
            return DB::transaction(function () use ($data) {
                return $this->createRetreatRequest($data, false);
            });
        }
        $retreatRequest = RetreatRequest::create($data->toArray());
        if (request()->has('service_ids')) {
            $retreatRequest->retreatServices()->sync(request()->get('service_ids'));
        }
        try {
            if ($retreatRequest->user->is_notifiable)
                $retreatRequest->user->notify(new RetreatRequestCreatedNotification($retreatRequest->user, $retreatRequest));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        activity()
            ->performedOn($retreatRequest)
            ->withProperties([
                'retreat_request_id' => $retreatRequest->id,
                'retreat_request_mosque_id' => $retreatRequest->retreatMosque->id,
                'retreat_request_location' => $retreatRequest->location,
                'retreat_request_start_time' => $retreatRequest->start_time,
                'retreat_request_end_time' => $retreatRequest->end_time,
                'retreat_user_id' => $retreatRequest->user->id,
                'retreat_user_name' => $retreatRequest->user->name,
            ])->log('Retreat request created');
        return $retreatRequest;
    }
    public function getRetreatMosques($perPage = 10)
    {
        return RetreatMosque::query()->filter()->paginate($perPage);
    }
    public function getRetreatMosqueLocations($perPage = 10)
    {
        return RetreatMosqueLocation::query()->filter()->paginate($perPage);
    }
    public function requestRetreatService(RetreatRequest $retreatRequest, $serviceIds)
    {
        $retreatRequest->retreatServices()->sync($serviceIds);
        foreach ($serviceIds as $serviceId) {
            $retreatRequest->retreatServices()->updateExistingPivot($serviceId, [
                'created_at' => now()
            ]);
        }
        if ($retreatRequest->user->is_notifiable)
            $retreatRequest->user->notify(new RetreatRequestServicesAddedNotification($retreatRequest->user, $retreatRequest));
        activity()
            ->performedOn($retreatRequest)
            ->withProperties([
                'retreat_request_id' => $retreatRequest->id,
                'retreat_request_mosque_id' => $retreatRequest->retreatMosque->id,
                'retreat_request_location' => $retreatRequest->location,
                'retreat_request_start_time' => $retreatRequest->start_time,
                'retreat_request_end_time' => $retreatRequest->end_time,
                'retreat_user_id' => $retreatRequest->user->id,
                'retreat_user_name' => $retreatRequest->user->name,
                'retreat_service_ids' => $serviceIds,
            ])->log('Retreat request service added');
        return $retreatRequest;
    }
    public function getRejectionReasons()
    {
        $rejectionReasons = Reason::where('type', ReasonTypesEnum::REJECT_REQUEST)->get();
        return $rejectionReasons;
    }
    public function getRetreatRequestLocation(RetreatRequest $retreatRequest)
    {
        return RetreatMosqueLocation::where('id', $retreatRequest->retreat_mosque_location_id)->first();
    }
    public function getQrCode($retreatRequest)
    {
        $qrCode = $retreatRequest->requestQrCode?->qr_code;
        return $qrCode;
    }
    public function checkQrCode($retreatRequestId)
    {
        $retreatRequest = RetreatRequest::findOrFail($retreatRequestId);
        $qrCode = $retreatRequest->requestQrCode;
        return $qrCode;
    }
}
