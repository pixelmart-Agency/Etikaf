<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RetreatRateSurveyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'retreat_rate_question_id' => $this->retreat_rate_question_id,
            'retreat_rate_answer_id' => $this->retreat_rate_answer_id,
            'retreat_request_id' => $this->retreat_request_id,
            'retreat_user_id' => $this->retreat_user_id,
            'text_answer' => $this->text_answer,
            'retreat_survey_id' => $this->retreat_survey_id,
            'retreat_rate_question' => RetreatRateQuestionResource::make($this->whenLoaded('retreatRateQuestion')),
            'retreat_rate_answer' => RetreatRateAnswerResource::make($this->whenLoaded('retreatRateAnswer')),
            'retreat_request' => RetreatRequestResource::make($this->whenLoaded('retreatRequest')),
        ];
    }
}
