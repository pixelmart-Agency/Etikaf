<?php

namespace App\Notifications;

use App\Services\FirebaseService;

class NotifyUsersForNewSurveyNotification extends BaseNotification
{
    protected $notifiable;
    protected $survey;

    public function __construct($notifiable, $survey)
    {
        $this->notifiable = $notifiable;
        $this->survey = $survey;
    }
    public function toDatabase()
    {
        if (!$this->notifiable->is_notifiable) {
            return;
        }
        $message = __('translation.new_survey :title', ['title' => getTransValue($this->survey->title)]);
        $firebaseService = new FirebaseService();
        $result = $firebaseService->setTitle(__('translation.new_survey'))
            ->setBody($message)
            ->setToken($this->notifiable->fcm_token)
            ->setData([
                'type' => 'new_survey',
                'survey_id' => $this->survey->id,
                'survey_title' => getTransValue($this->survey->title),
            ])
            ->send();
        activity()
            ->performedOn($this->survey)
            ->withProperties([
                'survey_id' => $this->survey->id,
                'survey_title' => getTransValue($this->survey->title),
                'result' => $result,
            ])
            ->log('New survey');

        return [
            'message' => $message,
            'title' => __('translation.new_survey'),
            'result' => $result,
        ];
    }
}
