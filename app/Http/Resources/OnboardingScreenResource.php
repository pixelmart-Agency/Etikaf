<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OnboardingScreenResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => getTransValue($this->title),
            'description' => getTransValue($this->description),
            'image_url' => $this->image_url,
        ];
    }
}
