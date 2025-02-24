<?php

namespace App\Http\Resources\Export;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\RetreatRequestService
 */
class RetreatRequestServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            __('translation.id') => $this->id,
            __('translation.national_id_passport') => $this->retreatRequest->user->document_number,
            __('translation.name_nationality') => $this->retreatRequest->user->name,
            __('translation.retreat_service_type') => getTransValue($this->retreatService->name),
            __('translation.mosque') => $this->retreatRequest->retreatMosque->name,
            __('translation.mosque_location') => $this->retreatRequest->retreatMosqueLocation->name,
            __('translation.retreat_request_date') => $this->retreatRequest->start_time,
            __('translation.status') => __('translation.' . $this->status),
        ];
    }
}
