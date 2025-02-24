<?php

namespace App\Http\Resources\Export;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\RetreatMosqueLocation
 */
class RetreatServiceResource extends JsonResource
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
            __('translation.name') => getTransValue($this->name),
            __('translation.service_category') => getTransValue($this->retreatServiceCategory->name),
            __('translation.sort_order') => $this->sort_order,
        ];
    }
}
