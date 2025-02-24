<?php

namespace App\Notifications;

use App\Services\FirebaseService;

class RetreatRequestRatedNotification extends BaseNotification
{
    protected $notifiable;
    protected $request;
    protected $rate;
    public function __construct($notifiable, $request, $rate)
    {
        $this->notifiable = $notifiable;
        $this->request = $request;
        $this->rate = $rate;
    }
    public function toDatabase()
    {
        if (!$this->notifiable->is_notifiable) {
            return;
        }
        $message = __(
            'translation.request_created_rated :user_name :request_id :created_at :rating',
            [
                'user_name' => $this->notifiable->name,
                'request_id' => $this->request->id,
                'created_at' => convertToHijri($this->request->created_at),
                'rating' => $this->rate->rate
            ]
        );
        $firebaseService = new FirebaseService();
        $result =  $firebaseService->setTitle(__('translation.rate_created'))
            ->setBody($message)
            ->setToken($this->notifiable->fcm_token)
            ->setData([
                'type' => 'request_rated',
                'user_name' => $this->notifiable->name,
                'request_id' => $this->request->id,
                'rating' => $this->rate->rate,
                'created_at' => $this->request->created_at->format('Y-m-d H:i:s'),
            ])
            ->send();
        return [
            'message' => $message,
            'title' => __('translation.rate_created'),
            'result' => $result,
        ];
    }
}
