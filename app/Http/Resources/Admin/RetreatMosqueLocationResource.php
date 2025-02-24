<?php

namespace App\Http\Resources\Admin;

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
            'id' => $this->id,
            'name' => getTransValue($this->name),
            'retreat_mosque_name' => getTransValue($this->retreatMosque?->name),
            'retreat_mosque_location_status' => $this->request_status,
            'request_count' => $this->retreatRequest()->count() . ' ' . __('translation.requests'),
            'sort_order' => $this->sort_order,
        ];
    }
}
