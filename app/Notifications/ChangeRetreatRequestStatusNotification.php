<?php

namespace App\Notifications;

use App\Services\FirebaseService;

class ChangeRetreatRequestStatusNotification extends BaseNotification
{
    protected $notifiable;
    protected $request;
    protected $old_status;
    protected $new_status;
    public function __construct($notifiable, $request, $old_status, $new_status)
    {
        $this->notifiable = $notifiable;
        $this->request = $request;
        $this->old_status = $old_status;
        $this->new_status = $new_status;
    }
    public function toDatabase()
    {
        if (!$this->notifiable->is_notifiable) {
            return;
        }
        $message = __(
            'translation.request_status_changed :request_id :old_status :new_status',
            ['request_id' => $this->request->id, 'old_status' => __('translation.' . $this->old_status), 'new_status' => __('translation.' . $this->new_status)]
        );
        $firebaseService = new FirebaseService();
        $result = $firebaseService->setTitle(__('translation.request_status :status', ['status' => __('translation.' . $this->new_status)]))
            ->setBody($message)
            ->setToken($this->notifiable->fcm_token)
            ->setData([
                'type' => 'request_status_changed',
                'request_id' => $this->request->id,
                'old_status' => $this->old_status,
                'new_status' => $this->new_status,

            ])
            ->send();
        return [
            'message' => $message,
            'title' => __('translation.request_status :status', ['status' => __('translation.' . $this->new_status)]),
            'result' => $result,
        ];
    }
}
