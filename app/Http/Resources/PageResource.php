<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => getTransValue($this->name),
            'slug' => $this->slug,
            'content' => $this->getContentForApi($this->content),
        ];
    }
}
