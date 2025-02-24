<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SurveyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => getTransValue($this->title),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->model_status->text,
            'retreat_rate_surveys' => RetreatRateSurveyResource::collection($this->whenLoaded('retreatRateSurveys')),
            'retreat_rate_questions' => RetreatRateQuestionResource::collection($this->whenLoaded('retreatRateQuestions')),
        ];
    }
}
