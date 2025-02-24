<?php

namespace App\Notifications;

use App\Enums\UserTypesEnum;
use App\Services\FirebaseService;

class NewMessageNotification extends BaseNotification
{
    protected $senderName;
    protected $message;
    protected $receiver;
    protected $firebase;

    public function __construct($senderName, $message, $receiver, $firebase = true)
    {
        $this->senderName = $senderName;
        $this->message = $message;
        $this->receiver = $receiver;
        $this->firebase = $firebase;
    }

    public function toDatabase()
    {
        if (!$this->receiver->is_notifiable) {
            return;
        }
        $message = __('translation.New message from :sender_name: :message', [
            'sender_name' => user()->user_type == UserTypesEnum::USER->value ? $this->senderName : __('translation.support_user'),
            'message' => $this->message
        ]);
        if ($this->firebase) {
            $firebaseService = new FirebaseService();
            $result = $firebaseService->setTitle(__('translation.New message'))
                ->setBody($message)
                ->setToken($this->receiver->fcm_token)
                ->setData([
                    'type' => 'new_message',
                    'sender_name' => $this->senderName,
                    'message' => $this->message,
                ])
                ->send();
        }
        return [
            'message' => $message,
            'title' => __('translation.New message'),
            'result' => $result,
        ];
    }
}
