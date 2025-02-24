<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\User
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => (string) $this->name,
            'email' => (string) $this->email,
            'mobile' => (string) $this->mobile,
            'user_type' => (string) $this->user_type,
            'document_type' => (string) $this->document_type,
            'document_type_translated' => __('translation.' . (string) $this->document_type),
            'document_number' => (string) $this->document_number,
            'visa_number' => (string) $this->visa_number,
            'birthday' => (string) $this->birthday,
            'app_user_type' => $this->app_user_type == 'visitor' ? $this->app_user_type : null,
            'token' => (string) $this->token,
            'otp' => (string) $this->otp,
            'avatar_url' => (string) $this->avatar_url,
            'country_id' => (int) $this->country_id,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'active_now' => (bool) $this->active_now,
            'unread_notifications_count' => (int) $this->unread_notifications_count,
            'notification_enabled' => (bool) $this->notification_enabled,
            'has_survey' => (bool) $this->has_survey,
            'today_date' => convertToHijri(Carbon::today()),
            'is_notifiable' => (bool) $this->is_notifiable,
        ];
    }
}
