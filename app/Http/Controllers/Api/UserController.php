<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Data\UserData;
use App\Enums\ReasonTypesEnum;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\ReasonResource;
use App\Http\Resources\UserResource;
use App\Models\Reason;
use App\Models\User;
use App\Notifications\AccountCreatedNotification;
use App\Notifications\AccountUpdatedNotification;
use App\Responses\ErrorResponse;
use App\Responses\SuccessResponse;
use App\Services\ForgotPasswordService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    protected $userService;
    protected $forgotPasswordService;

    public function __construct(UserService $userService, ForgotPasswordService $forgotPasswordService)
    {
        $this->userService = $userService;
        $this->forgotPasswordService = $forgotPasswordService;
    }


    public function create(UserRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $userData = UserData::fromArray($validatedData);
            $userData->is_active = false;
            $otp = $this->userService->createUser($userData, true);
            // $user = $this->userService->login($validatedData);

            return SuccessResponse::send($otp, __('translation.registered_successfully'), 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ErrorResponse::send($e->getMessage(), 500);
        }
    }
    public function activate(Request $request)
    {
        $request->validate([
            'otp' => [
                'required',
                'string',
                'exists:users,otp',
            ],
        ]);
        $otp = $request->otp;
        $user = $this->userService->activateUser($otp);
        $user = $this->userService->loginProcess($user);
        if ($user) {
            return SuccessResponse::send(UserResource::make($user), __('translation.activated_successfully'), 200);
        }
        return ErrorResponse::send(__('translation.otp_not_found'), 404);
    }


    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();
        $user = $this->userService->login($validatedData);
        if (!$user) {
            return ErrorResponse::send(__('translation.invalid_credentials'), 401);
        }
        if ($user == 'not_active') {
            return ErrorResponse::send(__('translation.user_not_active'), 401);
        }
        return SuccessResponse::send(UserResource::make($user), __('translation.registered_successfully'), 200);
    }

    public function update(UserRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $userData =  UserData::fromArray($validatedData);
            $userId = Auth::id();
            $updatedUser = $this->userService->updateUser($userId, $userData);
            if ($request->has('remove_avatar') && $request->get('remove_avatar')) {
                $updatedUser->clearAvatarAttribute();
            }
            return SuccessResponse::send(UserResource::make($updatedUser), __('translation.profile_updated_successfully'), 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ErrorResponse::send($e->getMessage(), 500);
        }
    }

    public function delete(Request $request)
    {
        $request->validate([
            'reason_id' => [
                'required',
                'integer',
                Rule::exists('reasons', 'id')->where('type', ReasonTypesEnum::DELETE_ACCOUNT),
                'max:255',
            ],
        ]);
        $userId = Auth::id();
        $deleted = $this->userService->deleteUser($userId, $request->reason_id);
        if ($deleted) {
            return SuccessResponse::send(1, __('translation.user_deleted_successfully'), 200);
        }
        return ErrorResponse::send(__('translation.user_not_found'), 404);
    }

    public function show()
    {
        $user = Auth::user();
        return SuccessResponse::send(UserResource::make($user), __('translation.user_found'), 200);
    }
    public function forgotPassword(Request $request)
    {
        $validatedData = $request->validate(
            [
                'mobile' => [
                    'required',
                    'exists:users,mobile',
                ]
            ]
        );

        $otp = $this->forgotPasswordService->sendVerificationCode($validatedData['mobile']);
        return SuccessResponse::send($otp, __('translation.verification_code_sent'), 200);
    }
    public function checkVerificationCode(Request $request)
    {
        $validatedData = $request->validate(
            [
                'otp' => [
                    'required',
                    'numeric',
                    'digits:4',
                    'exists:users,otp',
                ],
            ]
        );

        $user = $this->forgotPasswordService->verifyCode($validatedData['otp']);
        return SuccessResponse::send(UserResource::make($user), __('translation.user_found'), 200);
    }
    public function resetPassword(Request $request)
    {
        $validatedData = $request->validate(
            [
                'otp' => [
                    'required',
                    'numeric',
                    'digits:4',
                    'exists:users,otp',
                ],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'password_strength',
                    'confirmed',
                ],
            ]
        );
        $user = $this->forgotPasswordService->resetPassword($validatedData['otp'], $validatedData['password']);
        if ($user) {
            return SuccessResponse::send(UserResource::make($user), __('translation.password_updated_successfully'), 200);
        }
        return ErrorResponse::send(__('translation.user_not_found'), 404);
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => [
                'required',
                'string',
                'min:8',
                'password_strength',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'password_strength',
                'confirmed',
            ],
        ]);
        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return ErrorResponse::send(__('translation.old_password_not_correct'), 404);
        }
        $user = $this->userService->updatePassword($request->password, Auth::id());
        if ($user) {
            return SuccessResponse::send(UserResource::make($user), __('translation.password_updated_successfully'), 200);
        }
    }
    public function logout()
    {
        $this->userService->logout();
        return SuccessResponse::send(null, __('translation.logged_out'), 200);
    }
    public function switchNotificationSettings()
    {
        try {
            $user = Auth::user();
            $user = User::where('id', $user->id)->first();
            $user->notification_enabled = !$user->notification_enabled;
            $user->save();
            $new_notification_enabled = $user->notification_enabled;
            return SuccessResponse::send($new_notification_enabled, __('translation.notification_enabled_updated_successfully'), 200);
        } catch (\Exception $e) {
            return ErrorResponse::send(__('translation.notification_enabled_updated_failed'), 400);
        }
    }
    public function resendVerificationCode(Request $request)
    {
        $validatedData = $request->validate(
            [
                'mobile' => [
                    'required',
                    'exists:users,mobile',
                ]
            ]
        );
        $otp = $this->forgotPasswordService->sendVerificationCode($validatedData['mobile']);
        return SuccessResponse::send($otp, __('translation.verification_code_sent'), 200);
    }
    public function getDeleteReasons()
    {
        $delete_reasons = Reason::query()->filter()->deleteReasons()->get();
        $delete_reasons = ReasonResource::collection($delete_reasons);
        return SuccessResponse::send($delete_reasons, __('translation.delete_reasons'), 200);
    }
}
