<?php

namespace App\Http\Resources;

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
            'description' => getTransValue($this->description),
            'sort_order' => $this->sort_order,
            'retreat_mosque_id' => $this->retreat_mosque_id,
            'location' => $this->location,
            'lat' => to_location_obj($this->location, 'lat'),
            'lng' => to_location_obj($this->location, 'lng'),
            'image_url' => $this->image_url,
            'request_status' => $this->request_plain_status,
            'request_status_key' => $this->request_status_key,
        ];
    }
}
