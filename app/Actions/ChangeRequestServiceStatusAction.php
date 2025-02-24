<?php

namespace App\Actions;

use App\Enums\ProgressStatusEnum;
use App\Models\RetreatRequest;
use App\Models\RetreatRequestServiceModel;
use App\Models\User;
use App\Notifications\ChangeRequestServiceStatusNotification;
use App\Notifications\ChangeRetreatRequestStatusNotification;
use App\Notifications\EmployeeAssigedToServiceRequest;
use Illuminate\Support\Facades\DB;

class ChangeRequestServiceStatusAction
{
    public function execute(RetreatRequestServiceModel $retreatRequestServiceModel,  $status, $employee_id = null, $isTransaction = true)
    {
        if ($isTransaction) {
            return DB::transaction(function () use ($retreatRequestServiceModel, $status, $employee_id) {
                return $this->execute($retreatRequestServiceModel, $status, $employee_id, false);
            });
        }

        $oldStatus = $retreatRequestServiceModel->status;
        $retreatRequestServiceModel->update([
            'status' => $status,
            'employee_id' => $employee_id,
        ]);
        if ($retreatRequestServiceModel->retreatRequest->user->is_notifiable) {
            $retreatRequestServiceModel->retreatRequest->user->notify(new ChangeRequestServiceStatusNotification($retreatRequestServiceModel->retreatRequest->user, $retreatRequestServiceModel, $oldStatus, $status));
        }
        if ($employee_id && $status == ProgressStatusEnum::IN_PROGRESS) {
            $employee = User::where('id', $employee_id)->first();
            if ($employee && $employee->is_notifiable) {
                $employee->notify(new EmployeeAssigedToServiceRequest($employee, $retreatRequestServiceModel));
            }
        }
        $logMessage = 'Retreat service request status changed';
        if (!empty($employee_id)) {
            $logMessage .= ' and employee assigned';
        }
        activity()
            ->performedOn($retreatRequestServiceModel)
            ->withProperties([
                'retreat_request_id' => $retreatRequestServiceModel->id,
                'retreat_request_service_id' => $retreatRequestServiceModel->id,
                'retreat_request_service_old_status' => $oldStatus,
                'retreat_request_service_status' => $retreatRequestServiceModel->status,
                'retreat_request_service_employee_id' => $retreatRequestServiceModel->employee_id,
                'retreat_request_service_new_employee_id' => $employee_id,
            ])->log($logMessage);
        return $retreatRequestServiceModel;
    }
}
