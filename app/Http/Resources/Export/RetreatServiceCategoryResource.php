<?php

namespace App\Http\Resources\Export;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\RetreatInstruction
 */
class RetreatServiceCategoryResource extends JsonResource
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
        ];
    }
}
