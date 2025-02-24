<?php

namespace App\Actions;

use App\Enums\ProgressStatusEnum;
use App\Models\RetreatRequest;
use App\Notifications\ChangeRetreatRequestStatusNotification;
use Illuminate\Support\Facades\DB;
use App\Actions\CreateRequestQrCodeAction;
use Illuminate\Support\Facades\Log;

class ChangeTreatRequestStatusAction
{
    public function execute(RetreatRequest $retreatRequest,  $status, $isTransaction = true, $reason_id = null)
    {
        if ($isTransaction) {
            return DB::transaction(function () use ($retreatRequest, $status, $reason_id) {
                return $this->execute($retreatRequest, $status, false, $reason_id);
            });
        }

        $oldStatus = $retreatRequest->status;
        $retreatRequest->status = $status;
        if ($reason_id) {
            $retreatRequest->reason_id = $reason_id;
        }
        $retreatRequest->save();
        $retreatRequest->retreatServices()->update([
            'status' => $status,
        ]);
        if ($retreatRequest->user->is_notifiable) {
            $retreatRequest->user->notify(new ChangeRetreatRequestStatusNotification($retreatRequest->user, $retreatRequest, $oldStatus, $status));
        }
        activity()
            ->performedOn($retreatRequest)
            ->withProperties([
                'retreat_request_id' => $retreatRequest->id,
                'retreat_request_status' => $retreatRequest->status,
                'retreat_request_old_status' => $oldStatus,
            ])->log('Retreat request status changed');
        return $retreatRequest;
    }
}
