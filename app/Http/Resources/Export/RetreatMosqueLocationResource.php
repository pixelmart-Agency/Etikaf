<?php

namespace App\Http\Resources\Export;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\RetreatMosqueLocation
 */
class RetreatMosqueLocationResource extends JsonResource
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
            __('translation.mosque_location_name') => getTransValue($this->name),
            __('translation.retreat_mosque_name') => getTransValue($this->retreatMosque->name),
            __('translation.request_status') => strip_tags($this->request_status),
            __('translation.request_count') => $this->retreatRequest()->count(),
            __('translation.sort_order') => $this->sort_order,
        ];
    }
}
