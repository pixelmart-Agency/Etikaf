<?php

namespace Database\Factories;

use App\Enums\AppUserTypesEnum;
use App\Enums\UserTypesEnum;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'mobile' => $this->faker->unique()->phoneNumber,
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'user_type' => UserTypesEnum::USER->value,
            'document_type' => 'national_id',
            'document_number' => $this->faker->unique()->randomNumber(8),
            'visa_number' => $this->faker->unique()->randomNumber(8),
            'birthday' => $this->faker->date(),
            'app_user_type' => AppUserTypesEnum::CITIZEN->value,
            'country_id' => Country::inRandomOrder()->first()->id,
            'otp' => null,
            'token' => Str::random(10),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,

        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
