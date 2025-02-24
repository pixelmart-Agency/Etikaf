<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

class OnboardingScreenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $count = 1000;
        $i = $this->faker->numberBetween(1, $count);
        return [
            'title' => [
                'ar' => 'العنوان ' . $i,
            ],
            'description' => [
                'ar' => 'محتوى العنوان ' . $i,
            ],
        ];
    }
}
