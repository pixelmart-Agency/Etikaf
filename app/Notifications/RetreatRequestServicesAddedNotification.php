<?php

namespace App\Notifications;

use App\Services\FirebaseService;

class RetreatRequestServicesAddedNotification extends BaseNotification
{
    protected $notifiable;
    protected $request;
    public function __construct($notifiable, $request)
    {
        $this->notifiable = $notifiable;
        $this->request = $request;
    }
    public function toDatabase()
    {
        if (!$this->notifiable->is_notifiable) {
            return;
        }
        $message = __(
            'translation.request_created_services_added :user_name :request_id :created_at',
            [
                'user_name' => $this->notifiable->name,
                'request_id' => $this->request->id,
                'created_at' => convertToHijri($this->request->created_at->format('Y-m-d'))
            ]
        );
        $firebaseService = new FirebaseService();
        $result = $firebaseService->setTitle(__('translation.services_added'))
            ->setBody($message)
            ->setToken($this->notifiable->fcm_token)
            ->setData([
                'type' => 'services_added',
                'user_name' => $this->notifiable->name,
                'request_id' => $this->request->id,
                'created_at' => $this->request->created_at->format('Y-m-d H:i:s'),
            ])
            ->send();
        return [
            'message' => $message,
            'title' => __('translation.services_added'),
            'result' => $result,
        ];
    }
}
