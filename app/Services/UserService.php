<?php

namespace App\Services;

use App\Actions\SendEmployeeJoinEmailAction;
use App\Data\UserData;
use App\Enums\UserTypesEnum;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Notifications\AccountCreatedNotification;
use App\Notifications\AccountUpdatedNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    protected $nafathService;
    public function __construct(NafathService $nafathService)
    {
        $this->nafathService = $nafathService;
    }
    /**
     * إنشاء مستخدم جديد.
     */
    public function createUser(UserData $userData, $otp = false, $inTransaction = true)
    {
        if ($inTransaction) {
            return DB::transaction(function () use ($userData, $otp) {
                return $this->createUser($userData, $otp, false);
            });
        }
        if ($userData->user_type == UserTypesEnum::EMPLOYEE->value) {
            $userData->is_active = $userData->is_active ?? true;
        }
        // $userData->password = Hash::make($userData->password);
        $response = $this->nafathService->sendLoginRequest($userData->document_number);
        $user = User::create($userData->toArray());
        $user = $this->fromNafath($user, $response);
        $user->update(['password' => Hash::make($userData->password)]);
        if (request()->hasFile('avatar')) {
            $user->setAvatarAttribute(request()->file('avatar'));
        }
        if ($userData->user_type != UserTypesEnum::ADMIN->value && $userData->user_type != UserTypesEnum::EMPLOYEE->value) {
            $otp = $this->sendVerificationCode($user);
        }
        if ($userData->user_type == UserTypesEnum::EMPLOYEE->value && $userData->email) {
            try {
                $sendEmployeeJoinEmailAction = new SendEmployeeJoinEmailAction();
                $sendEmployeeJoinEmailAction->execute($user);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }
        // $user->notify(new AccountCreatedNotification($user));
        if ($otp) {
            return $otp;
        } else {
            return $user;
        }
    }
    public function fromNafath($user, $response)
    {
        if ($response['status'] == 200) {
            $user->is_active = true;
            $user->otp = null;
            $user->token = null;
        } else {
            $user->name = !empty($user->name) ? $user->name : 'عبد الله مسلم';
            $user->birthday = $user->birthday ?? Carbon::now()->subYears(20)->format('Y-m-d');
        }
        $user->save();
        return $user;
    }
    public function activateUser($otp)
    {
        $user = User::where('otp', $otp)->first();
        if ($user) {
            $user->is_active = true;
            $user->otp = null;
            $user->save();
            return $user;
        }
        return false;
    }
    public function login($validatedData)
    {
        $user = User::query()->where(function ($query) use ($validatedData) {
            $query->where('document_number', $validatedData['document_number'])
                ->when(request()->has('document_type'), function ($query) use ($validatedData) {
                    $query->where('document_type', $validatedData['document_type']);
                })
                ->where('user_type', UserTypesEnum::USER->value);
        })->orWhere(function ($query) use ($validatedData) {
            $query->where('mobile', $validatedData['document_number'])
                ->where('user_type', UserTypesEnum::EMPLOYEE->value);
        })->first();
        if ($user && !$user->is_active) {
            return 'not_active';
        }
        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return false;
        }
        if (request()->has('fcm_token')) {
            $user->update(['fcm_token' => request()->fcm_token]);
        }
        $user = $this->loginProcess($user);
        return $user;
    }
    public function loginProcess($user)
    {
        $token = $user->createToken('auth_token')->plainTextToken;
        $user->token = $token;
        return $user;
    }
    public function updateUser(int $userId, UserData $userData, $inTransaction = true)
    {
        if ($inTransaction) {
            return DB::transaction(function () use ($userId, $userData) {
                return $this->updateUser($userId, $userData, false);
            });
        }
        $user = User::find($userId);

        if ($user) {
            if ($userData->name) {
                $user->name = $userData->name;
            }

            if ($userData->email) {
                $user->email = $userData->email;
            }

            if ($userData->mobile) {
                $user->mobile = $userData->mobile;
            }

            if ($userData->password) {
                $user->password = Hash::make($userData->password);
            }

            if ($userData->user_type) {
                $user->user_type = $userData->user_type;
            }

            if ($userData->document_type) {
                $user->document_type = $userData->document_type;
            }

            if ($userData->document_number) {
                $user->document_number = $userData->document_number;
            }

            if ($userData->visa_number) {
                $user->visa_number = $userData->visa_number;
            }

            if ($userData->birthday) {
                $user->birthday = $userData->birthday;
            }

            if ($userData->app_user_type) {
                $user->app_user_type = $userData->app_user_type;
            }

            if ($userData->country_id) {
                $user->country_id = $userData->country_id;
            }
            if (isset($userData->is_active)) {
                $user->is_active = $userData->is_active;
            }
            if (request()->hasFile('avatar')) {
                $user->setAvatarAttribute(request()->file('avatar'));
            }
            $user->save();
            if ($user->is_notifiable)
                $user->notify(new AccountUpdatedNotification($user));
            return $user;
        }

        return null;
    }


    public function deleteUser(int $userId, string $deleteReason, bool $isTransaction = true): bool
    {
        if ($isTransaction) {
            return DB::transaction(function () use ($userId, $deleteReason) {
                return $this->deleteUser($userId, $deleteReason, false);
            });
        }
        $user = User::find($userId);
        if ($user) {
            $user->update(['reason_id' => $deleteReason]);
            auth('sanctum')->user()->currentAccessToken()->delete();
            return $user->delete();
        }
        return false;
    }

    public function getUserById(int $userId): ?User
    {
        return User::find($userId);
    }


    public function getAllUsers()
    {
        return User::query()->filter()->paginate(20);
    }
    public function updatePassword($newPassword, $userId)
    {
        $user = User::find($userId);
        // $user->setPasswordAttribute($newPassword);
        $user->password = Hash::make($newPassword);
        $user->save();
        activity()
            ->performedOn($user)
            ->withProperties([
                'user_id' => $userId,
            ])->log('Password updated');
        $user = $this->loginProcess($user);
        return $user;
    }
    public function logout()
    {
        auth('sanctum')->user()->currentAccessToken()->delete();
        return true;
    }
    public function sendVerificationCode(User $user)
    {
        do {
            $otp = generateNumber();
        } while (User::where('otp', $otp)->exists());

        $user->otp = $otp;
        $user->save();
        $smsService = new SmsService();
        $smsService->setMessage(__('translation.verification_code_sent :otp', ['otp' => $otp]));
        $smsService->setRecipient($user->mobile);
        $smsService->sendSms();
        return $otp;
    }
}
