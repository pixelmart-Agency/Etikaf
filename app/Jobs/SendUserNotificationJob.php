<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\NotifyUsersForNewSurveyNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendUserNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $survey;

    public function __construct($userId, $survey)
    {
        $this->userId = $userId;
        $this->survey = $survey;
    }

    public function handle()
    {
        $user = User::find($this->userId);

        if ($user && $user->is_notifiable) {
            $user->notify(new NotifyUsersForNewSurveyNotification($user, $this->survey));
            activity()
                ->performedOn($user)
                ->withProperties([
                    'survey_id' => $this->survey->id,
                    'survey_title' => getTransValue($this->survey->title),
                ])
                ->log('New survey');
        }
    }
}
