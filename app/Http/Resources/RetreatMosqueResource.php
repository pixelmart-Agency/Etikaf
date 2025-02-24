<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\RetreatMosque
 */
class RetreatMosqueResource extends JsonResource
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
            'image' => (string)$this->image_url,
        ];
    }
}
