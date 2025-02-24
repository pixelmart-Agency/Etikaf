<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SurveyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => getTransValue($this->title),
            'start_date' => convertToHijri($this->start_date),
            'end_date' => convertToHijri($this->end_date),
        ];
    }
}
