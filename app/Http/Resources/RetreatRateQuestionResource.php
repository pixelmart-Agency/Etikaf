<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RetreatRateQuestionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'question' => getTransValue($this->question),
            'type' => $this->type,
            'answer_type' => $this->answer_type,
            'retreat_survey_id' => $this->retreat_survey_id,
            'retreat_rate_answers' => RetreatRateAnswerResource::collection($this->whenLoaded('retreatRateAnswers')),
        ];
    }
}
