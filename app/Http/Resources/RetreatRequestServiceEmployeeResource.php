<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\RetreatRequestService
 */
class RetreatRequestServiceEmployeeResource extends RetreatRequestServiceResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        $data['user'] = SimpleUserResource::make($this->retreatRequest->user()->with('country')->first());

        return $data;
    }
}
