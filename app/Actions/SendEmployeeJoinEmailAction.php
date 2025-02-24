<?php

namespace App\Actions;

use App\Mail\EmployeeJoinMail;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendEmployeeJoinEmailAction
{
    public function execute(User $user, $isTransaction = true)
    {
        if ($isTransaction) {
            return DB::transaction(function () use ($user) {
                return $this->execute($user, false);
            });
        }
        Mail::to($user->email)->send(new EmployeeJoinMail($user));
        $smsService = new SmsService();
        $smsService->setMessage(__('translation.employee_join_sms_body'));
        $smsService->setRecipient($user->mobile);
        $smsService->sendSms();
        $logMessage = 'Employee join email sent';

        activity()
            ->performedOn($user)
            ->withProperties([
                'user_id' => $user->id,
                'user_email' => $user->email,
            ])->log($logMessage);
        return $user;
    }
}
