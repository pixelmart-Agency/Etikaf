<?php

namespace App\Jobs;

use App\Models\RetreatSurvey;
use App\Models\Survey;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DailySurveyNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct() {}

    public function handle()
    {
        $today = Carbon::now()->toDateString();
        $survey = RetreatSurvey::whereDate('start_date', '=', $today)
            ->where('is_active', true)
            ->first();
        $users = $survey->getUsersWithApprovedOrCompletedStatus();

        foreach ($users as $userId) {
            SendUserNotificationJob::dispatch($userId, $survey);
        }
    }
}
