<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\RetreatService
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
            'description' => getTransValue($this->description),
            'sort_order' => $this->sort_order,
            'retreat_service_category_id' => $this->retreat_service_category_id,
            'image_url' => (string) $this->image_url,
            'created_at' => $this->created_at->format('Y-m-d'),
            'is_requested' => $this->is_requested,
        ];
    }
}
