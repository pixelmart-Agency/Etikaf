<?php

namespace App\Notifications;

use App\Services\FirebaseService;

class ChangeRequestServiceStatusNotification extends BaseNotification
{
    protected $notifiable;
    protected $requestService;
    protected $old_status;
    protected $new_status;
    public function __construct($notifiable, $requestService, $old_status, $new_status)
    {
        $this->notifiable = $notifiable;
        $this->requestService = $requestService;
        $this->old_status = $old_status;
        $this->new_status = $new_status;
    }
    public function toDatabase()
    {
        if (!$this->notifiable->is_notifiable) {
            return;
        }
        $message = __(
            'translation.request_service_status_changed :request_id :old_status :new_status',
            ['request_id' => $this->requestService->id, 'old_status' => __('translation.' . $this->old_status), 'new_status' => __('translation.' . $this->new_status)]
        );
        $firebaseService = new FirebaseService();
        $result = $firebaseService->setTitle(__('translation.request_status :status', ['status' => __('translation.' . $this->new_status)]))
            ->setBody($message)
            ->setToken($this->notifiable->fcm_token)
            ->setData([
                'type' => 'request_service_status_changed',
                'request_id' => $this->requestService->id,
                'old_status' => $this->old_status,
                'new_status' => $this->new_status,
                'retreat_request_id' => $this->requestService->retreatRequest->id,
                'retreat_request_status' => $this->requestService->retreatRequest->status,
                'retreat_employee_id' => $this->requestService->employee?->id,
                'retreat_employee_name' => $this->requestService->employee?->name,

            ])
            ->send();
        return [
            'message' => $message,
            'title' => __('translation.request_status :status', ['status' => __('translation.' . $this->new_status)]),
            'result' => $result,
        ];
    }
}
