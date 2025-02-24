<?php

namespace App\Notifications;

use App\Services\FirebaseService;

class AccountCreatedNotification extends BaseNotification
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
        $message = __('translation.Account created successfully :user_name', ['user_name' => $this->notifiable->name]);
        $firebaseService = new FirebaseService();
        $result = $firebaseService->setTitle(__('translation.Account created'))
            ->setBody($message)
            ->setToken($this->notifiable->fcm_token)
            ->setData([
                'type' => 'account_created',
                'user_name' => $this->notifiable->name,
            ])
            ->send();
        return [
            'message' => $message,
            'title' => __('translation.Account created'),
            'result' => $result,
        ];
    }
}
