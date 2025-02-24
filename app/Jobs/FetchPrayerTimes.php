<?php

namespace App\Jobs;


use App\Models\PrayerTime;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FetchPrayerTimes implements ShouldQueue
{
    use Queueable;
    use Dispatchable;
    public function handle()
    {
        $city = 'Mekka';
        $country = 'Saudi Arabia';

        $response = Http::get('https://api.aladhan.com/v1/timingsByCity', [
            'city' => $city,
            'country' => $country,
            'method' => 2
        ]);

        if ($response->successful()) {

            $prayerTimes = PrayerTime::updateOrCreate(
                ['city' => $city, 'country' => $country],
                [
                    'timings' => json_encode($response->json()['data']['timings']),
                    'fetched_at' => Carbon::now(),
                ]
            );
        }
    }
}
