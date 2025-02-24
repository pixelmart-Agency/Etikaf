<?php

namespace App\Notifications;

use App\Services\FirebaseService;

class EmployeeAssigedToServiceRequest extends BaseNotification
{
    protected $notifiable;
    protected $requestService;
    protected $old_status;
    protected $new_status;
    public function __construct($notifiable, $requestService)
    {
        $this->notifiable = $notifiable;
        $this->requestService = $requestService;
    }
    public function toDatabase()
    {
        if (!$this->notifiable->is_notifiable) {
            return;
        }
        $message = __(
            'translation.employee_assiged_to_request_service :request_id',
            ['request_id' => $this->requestService->id]
        );
        $firebaseService = new FirebaseService();
        $result = $firebaseService->setTitle(__('translation.assigned_to_service'))
            ->setBody($message)
            ->setToken($this->notifiable->fcm_token)
            ->setData([
                'type' => 'request_service_status_changed',
                'request_id' => $this->requestService->id,
                'retreat_request_id' => $this->requestService->retreatRequest->id,
                'retreat_request_status' => $this->requestService->retreatRequest->status,
                'retreat_employee_id' => $this->requestService->employee?->id,
                'retreat_employee_name' => $this->requestService->employee?->name,

            ])
            ->send();
        return [
            'message' => $message,
            'title' => __('translation.assigned_to_service'),
            'result' => $result,
        ];
    }
}
