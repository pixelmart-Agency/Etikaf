<?php

namespace App\Http\Resources\Export;

use Illuminate\Http\Resources\Json\JsonResource;

class OnboardingScreenResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            __('translation.id') => $this->id,
            __('translation.title') => getTransValue($this->title),
        ];
    }
}
