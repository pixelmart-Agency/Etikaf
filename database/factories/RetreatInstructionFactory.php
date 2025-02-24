<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RetreatInstructionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $count = 10;
        $i = $this->faker->numberBetween(1, $count);

        return [
            'name' => [
                'ar' => 'الإرشادات ' . $i,
            ],
            'description' => [
                'ar' => 'وصف الإرشادات ' . $i,
            ],
            'sort_order' => $this->faker->numberBetween(1, 10),
        ];
    }
}
