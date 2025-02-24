<?php

namespace App\Http\Resources\Export;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\User
 */
class UserResource extends JsonResource
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
            __('translation.name') => (string) $this->name,
            __('translation.Email') => (string) $this->email,
            __('translation.Mobile') => (string) $this->mobile,
            __('translation.document_type') => (string) __('translation.' . $this->document_type),
            __('translation.document_number') => (string) $this->document_number,
            __('translation.created_at') => (string) $this->created_at,
        ];
    }
}
