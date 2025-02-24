<?php

namespace App\Http\Resources\Export;

use Illuminate\Http\Resources\Json\JsonResource;

class SurveyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            __('translation.id') => $this->id,
            __('translation.survey_title') => getTransValue($this->title),
            __('translation.survey_start_date') => $this->start_date,
            __('translation.survey_end_date') => $this->end_date,
        ];
    }
}
