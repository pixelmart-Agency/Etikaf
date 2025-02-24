<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\RetreatRequest
 */
class RetreatRequestResource extends JsonResource
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
            'retreat_mosque_id' => $this->retreat_mosque_id,
            'retreat_mosque_location_id' => $this->retreat_mosque_location_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'document_number' => $this->document_number,
            'birthday' => $this->birthday,
            'phone' => $this->phone,
            'qr_code' => (string)$this->qr_code,
            'status' => $this->status,
            'status_translated' => __('translation.' . $this->status),
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->updated_at->format('Y-m-d'),
            'retreat_mosque' =>  RetreatMosqueResource::make($this->whenLoaded('retreatMosque')),
            'retreat_mosque_location' =>  RetreatMosqueLocationResource::make($this->whenLoaded('retreatMosqueLocation')),
            'retreat_services' => RetreatRequestServiceResource::collection($this->whenLoaded('retreatRequestServices')),
            'request_qr_codes' => RequestQrCodeResource::make($this->whenLoaded('requestQrCode')),
        ];
    }
}
