<?php

namespace Database\Factories;

use App\Models\RetreatServiceCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class RetreatServiceCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $count = 10;
        $names = [];

        for ($i = 1; $i <= $count; $i++) {
            $names[] = 'قسم ' . $i;
        }

        return [
            'name' => $names[array_rand($names)],
        ];
    }
}
