<?php

namespace App\Actions;

use App\Jobs\SendUserNotificationJob;
use App\Models\RetreatSurvey;
use Illuminate\Support\Facades\DB;

class SendUserNotificationAction
{
    public function execute(RetreatSurvey $survey, $isTransaction = true)
    {
        if ($isTransaction) {
            return DB::transaction(function () use ($survey) {
                return $this->execute($survey, false);
            });
        }
        $users = $survey->getUsersWithApprovedOrCompletedStatus();
        foreach ($users as $userId) {
            SendUserNotificationJob::dispatch($userId, $survey);
        }
    }
}
