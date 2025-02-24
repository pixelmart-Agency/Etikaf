<?php

namespace Database\Factories;

use App\Enums\ReasonTypesEnum;
use App\Models\Reason;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReasonFactory extends Factory
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
            'title' => [
                'ar' => 'السبب ' . $i,
            ],
            'type' => ReasonTypesEnum::REJECT_REQUEST,
        ];
    }
}
