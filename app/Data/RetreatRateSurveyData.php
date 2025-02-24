<?php

namespace App\Data;

class RetreatRateSurveyData
{
    public ?array $retreat_rate_question_ids = null;
    public ?array $retreat_rate_answer_ids = null;
    public ?int $retreat_request_id = null;
    public ?array $text_answers = null;
    public ?int $retreat_user_id = null;
    public static function fromArray(array $data): self
    {
        $instance = new self();
        $instance->retreat_rate_question_ids = $data['retreat_rate_question_ids'] ?? null;
        $instance->retreat_rate_answer_ids = $data['retreat_rate_answer_ids'] ?? null;
        $instance->retreat_request_id = $data['retreat_request_id'] ?? null;
        $instance->text_answers = $data['text_answers'] ?? null;
        $instance->retreat_user_id = $data['retreat_user_id'] ?? null;

        return $instance;
    }
    public function toArray(): array
    {
        return [
            'retreat_rate_question_ids' => $this->retreat_rate_question_ids,
            'retreat_rate_answer_ids' => $this->retreat_rate_answer_ids,
            'retreat_request_id' => $this->retreat_request_id,
            'text_answers' => $this->text_answers,
            'retreat_user_id' => $this->retreat_user_id,
        ];
    }
}
