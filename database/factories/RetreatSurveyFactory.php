<?php

namespace Database\Factories;

use App\Models\RetreatSurvey;
use App\Models\RetreatRateQuestion;
use App\Models\RetreatRateAnswer;
use Illuminate\Database\Eloquent\Factories\Factory;

class RetreatSurveyFactory extends Factory
{
    protected $model = RetreatSurvey::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'start_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }

    public function withRelations($questionsCount = 3, $answersPerQuestion = 4)
    {
        return $this->afterCreating(function (RetreatSurvey $survey) use ($questionsCount, $answersPerQuestion) {
            $questions = RetreatRateQuestion::factory($questionsCount)->create(['retreat_survey_id' => $survey->id]);

            foreach ($questions as $question) {
                RetreatRateAnswer::factory($answersPerQuestion)->create(['retreat_rate_question_id' => $question->id]);
            }
        });
    }
}
