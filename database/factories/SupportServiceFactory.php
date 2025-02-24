<?php

namespace Database\Factories;

use App\Enums\SupportServiceTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupportServiceFactory extends Factory
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
            'type' => [
                SupportServiceTypeEnum::SUPPORT->value,
                SupportServiceTypeEnum::IN_RETREAT->value
            ][array_rand([
                SupportServiceTypeEnum::SUPPORT->value,
                SupportServiceTypeEnum::IN_RETREAT->value
            ])],
        ];
    }
}
