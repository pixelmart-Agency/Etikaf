<?php

namespace App\Http\Resources\Admin;

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
            'id' => $this->id,
            'name' => getTransValue($this->name),
            'retreat_service_category_name' => getTransValue($this->retreatServiceCategory?->name),
            'sort_order' => $this->sort_order,
        ];
    }
}
