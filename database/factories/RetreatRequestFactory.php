<?php

namespace Database\Factories;

use App\Enums\ProgressStatusEnum;
use App\Models\Country;
use App\Models\RetreatMosque;
use App\Models\RetreatMosqueLocation;
use App\Models\RetreatRequest;
use App\Models\RetreatService;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Prompts\Progress;

class RetreatRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RetreatRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $mosque = RetreatMosque::inRandomOrder()->first();
        $mosqueLocation = RetreatMosqueLocation::where('retreat_mosque_id', $mosque->id)->inRandomOrder()->first();
        $user = User::where('id', '!=', 1)->inRandomOrder()->first();
        return [
            'retreat_mosque_id' => $mosque->id,
            'retreat_mosque_location_id' => $mosqueLocation->id,
            'start_time' => Carbon::now()->addDays(1)->toDateTimeString(),
            'end_time' => Carbon::now()->addDays(2)->toDateTimeString(),
            'user_id' => $user->id,
            'name' => $user->name,
            'document_number' => $user->document_number,
            'birthday' => $user->birthday,
            'phone' => $user->phone,
            'qr_code' => $user->qr_code,
            'status' => ProgressStatusEnum::PENDING->value,
            'retreat_season_id' => currentSeason()->id,
        ];
    }
    public function withRelations()
    {
        return $this->afterCreating(function (RetreatRequest $request) {
            $request->retreatServices()->sync(
                RetreatService::inRandomOrder()->first()->id,
                [
                    'status' => ProgressStatusEnum::IN_PROGRESS->value,
                    'employee_id' => 33,
                ]
            );
        });
    }
}
