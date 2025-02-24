<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SimpleUserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'avatar_url' => (string) $this->avatar_url,
            'active_now' => (bool) $this->active_now,
            'country' => CountryResource::make($this->whenLoaded('country')),
            'document_number' => $this->document_number,
            'document_type' => $this->document_type,


        ];
    }
}
