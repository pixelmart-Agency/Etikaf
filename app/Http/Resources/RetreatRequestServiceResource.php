<?php

namespace App\Http\Resources;

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
            'id' => $this->id,
            'retreat_request_id' => $this->retreat_request_id,
            'retreat_service_id' => $this->retreat_service_id,
            'status' => $this->status,
            'status_translated' => __('translation.' . $this->status),
            'employee_id' => $this->employee_id,
            'created_at' => convertToHijri($this->created_at),
            'retreat_service' => RetreatServiceResource::make($this->whenLoaded('retreatService')),
            'retreat_mosque_location' => RetreatMosqueLocationResource::make($this->retreatRequest?->retreatMosqueLocation),
        ];
    }
}
