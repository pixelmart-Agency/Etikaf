<?php

namespace Database\Factories;

use App\Models\RetreatMosque;
use Illuminate\Database\Eloquent\Factories\Factory;

class RetreatMosqueLocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word, // اسم عشوائي
            'description' => $this->faker->sentence, // وصف عشوائي
            'sort_order' => $this->faker->numberBetween(1, 10), // ترتيب عشوائي
            'retreat_mosque_id' => RetreatMosque::inRandomOrder()->first()->id, // رقم المسجد
            'location' => '21.4225,39.8262'
        ];
    }
}
