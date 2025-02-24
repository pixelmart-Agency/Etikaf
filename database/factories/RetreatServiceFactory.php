<?php

namespace Database\Factories;

use App\Models\RetreatService;
use App\Models\RetreatServiceCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class RetreatServiceFactory extends Factory
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
            'name' => 'خدمة ' . $i,
            'description' => 'وصف خدمة ' . $i,
            'sort_order' => $this->faker->numberBetween(1, 10),
            'retreat_service_category_id' => RetreatServiceCategory::inRandomOrder()->first()->id,
        ];
    }
}
