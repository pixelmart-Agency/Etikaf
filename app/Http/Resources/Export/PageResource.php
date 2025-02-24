<?php

namespace App\Http\Resources\Export;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            __('translation.id') => $this->id,
            __('translation.name') => getTransValue($this->name),
            __('translation.slug') => $this->slug,
        ];
    }
}
