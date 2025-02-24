<?php

namespace Database\Factories;

use App\Models\RetreatRateQuestion;
use App\Models\RetreatSurvey;
use Illuminate\Database\Eloquent\Factories\Factory;

class RetreatRateQuestionFactory extends Factory
{
    protected $model = RetreatRateQuestion::class;

    public function definition()
    {
        return [
            'question' => $this->faker->sentence,
            'type' => $this->faker->randomElement(['text', 'choice', 'rating']),
            'answer_type' => $this->faker->randomElement(['single', 'multiple']),
            'sort_order' => $this->faker->numberBetween(1, 10),
            'retreat_survey_id' => RetreatSurvey::factory(),
        ];
    }
}
