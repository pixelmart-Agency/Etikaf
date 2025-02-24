<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RetreatRateAnswerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'answer' => $this->answer,
            'retreat_rate_question_id' => $this->retreat_rate_question_id,
            'text_color' => $this->text_color,
            'background_color' => $this->background_color,
        ];
    }
}
