<?php

namespace App\Console;

use App\Jobs\DailySurveyNotificationJob;
use App\Jobs\FetchPrayerTimes;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            app()->make(FetchPrayerTimes::class)->handle();
        })->dailyAt('00:00');
        $schedule->call(function () {
            app()->make(DailySurveyNotificationJob::class)->handle();
        })->dailyAt('17:14');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
