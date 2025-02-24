<?php

namespace Database\Factories;

use App\Models\RetreatRateAnswer;
use App\Models\RetreatRateQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class RetreatRateAnswerFactory extends Factory
{
    protected $model = RetreatRateAnswer::class;

    public function definition()
    {
        return [
            'answer' => $this->faker->sentence,
            'retreat_rate_question_id' => RetreatRateQuestion::factory(),
            'text_color' => $this->faker->hexColor,
            'background_color' => $this->faker->hexColor,
        ];
    }
}
