<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Responses\ErrorResponse;

class ForgotPasswordService
{

    public function sendVerificationCode(string $mobile)
    {
        do {
            $otp = random_int(1111, 9999);
        } while (User::where('otp', $otp)->exists());

        $user = User::where('mobile', $mobile)->first();
        if ($user) {
            $user->update(['otp' => $otp]);
        }

        $smsService = new SmsService();
        $smsService->setMessage(__('translation.verification_code_sent :otp', ['otp' => $otp]));
        $smsService->setRecipient($mobile);
        $smsService->sendSms();
        return $otp;
    }

    public function verifyCode(string $otp)
    {
        $user = User::where('otp', $otp)->first();
        if ($user) {
            return $user;
        }
        return false;
    }
    public function resetPassword(string $code, string $newPassword)
    {
        $user = $this->verifyCode($code);
        if ($user) {
            $user->password = Hash::make($newPassword);
            $user->update(['otp' => null]);
            activity()
                ->performedOn($user)
                ->withProperties([
                    'user_id' => $user->id,
                ])->log('Password reset');
            return $user;
        }
        return false;
    }
}
