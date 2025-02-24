<?php

namespace App\Notifications;

use App\Services\FirebaseService;

class AccountUpdatedNotification extends BaseNotification
{
    protected $notifiable;
    public function __construct($notifiable)
    {
        $this->notifiable = $notifiable;
    }
    public function toDatabase()
    {
        if (!$this->notifiable->is_notifiable) {
            return;
        }
        $message = __('translation.Account updated successfully :user_name', ['user_name' => $this->notifiable->name]);
        $firebaseService = new FirebaseService();
        $result = $firebaseService->setTitle(__('translation.Account updated'))
            ->setBody($message)
            ->setToken($this->notifiable->fcm_token)
            ->setData([
                'type' => 'account_updated',
                'user_name' => $this->notifiable->name,
            ])
            ->send();
        return [
            'message' => $message,
            'title' => __('translation.Account updated'),
            'result' => $result,
        ];
    }
}
