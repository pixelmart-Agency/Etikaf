<?php

namespace App\Http\Resources\Export;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\RetreatRequest
 */
class RetreatRequestResource extends JsonResource
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
            __('translation.national_id_passport') => $this->user->document_number,
            __('translation.name_nationality') => $this->user->name,
            __('translation.mosque') => $this->retreatMosque->name,
            __('translation.age') => $this->user->age,
            __('translation.mosque_location') => $this->retreatMosqueLocation->name,
            __('translation.retreat_date') => $this->start_time,
            __('translation.status') => $this->status,
        ];
    }
}
