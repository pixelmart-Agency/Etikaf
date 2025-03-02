<?php

namespace App\Models;

use App\Enums\ProgressStatusEnum;
use App\Enums\UserTypesEnum;
use App\Traits\LogsActivityTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, InteractsWithMedia, HasApiTokens, SoftDeletes, LogsActivityTrait, HasRoles;
    public $timestamps = true;

    protected static function booted()
    {
        static::saving(function ($user) {
            if (request()->has('fcm_token')) {
                User::where('fcm_token', request()->fcm_token)
                    ->where('id', '!=', $user->id)
                    ->update(['fcm_token' => NULL]);
                $user->fcm_token = request()->fcm_token;
            }
        });

        static::deleting(function ($user) {
            $user->notifications()->delete();
            $user->tokens->each->delete();
            $user->clearAvatarAttribute();
            $user->retreatRequests()->delete();
            $user->retreatRateSurveys()->delete();
            $user->chats()->delete();
        });
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function deleteRelations()
    {
        $this->notifications()->delete();
        $this->tokens->each->delete();
        $this->clearAvatarAttribute();
        $this->retreatRequests()->delete();
        $this->retreatRateSurveys()->delete();
        $this->chats()->delete();
    }
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'user_type',
        'document_type',
        'document_number',
        'visa_number',
        'otp',
        'birthday',
        'app_user_type',
        'country_id',
        'reason_id',
        'last_active_at',
        'notification_enabled',
        'is_active',
        'token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];
    public function scopeFilter($query)
    {
        if (request()->has('keyword')) {
            $query->where('name', 'like', '%' . request()->keyword . '%')
                ->orWhere('email', 'like', '%' . request()->keyword . '%')
                ->orWhere('mobile', 'like', '%' . request()->keyword . '%')
                ->orWhere('document_number', 'like', '%' . request()->keyword . '%')
                ->orWhere('visa_number', 'like', '%' . request()->keyword . '%')
                ->orWhere('birthday', 'like', '%' . request()->keyword . '%')
                ->orWhere('app_user_type', 'like', '%' . request()->keyword . '%')
                ->orWhere('user_type', 'like', '%' . request()->keyword . '%');
        }
        if (request()->has('country_id')) {
            $query->where('country_id', request()->country_id);
        }
        return $query->orderBy('id', 'desc');
    }
    public function chats()
    {
        return $this->hasMany(Chat::class, 'sender_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
    public function getUnreadNotificationsCountAttribute()
    {
        return $this->notifications()->unread()->count();
    }
    public function retreatRequests()
    {
        return $this->hasMany(RetreatRequest::class);
    }
    public function permissions(): BelongsToMany
    {
        return $this->morphToMany(Permission::class, 'model', 'model_has_permissions', 'model_id', 'permission_id');
    }
    public function getRequestStatusAttribute()
    {
        $currentSeason = currentSeason();
        if (!$currentSeason) {
            return __('translation.season_is_closed');
        }
        $currentRequest = $this->retreatRequests()->where('retreat_season_id', $currentSeason->id)->first();
        if (!$currentRequest) {
            return __('translation.no_request_status');
        }

        $status = $this->retreatRequests()->where('retreat_season_id', $currentSeason->id)->first()->status;
        return __('translation.' . $status);
    }
    public function getStatusClassAttribute()
    {
        $currentSeason = currentSeason();
        if (!$currentSeason) {
            return 'unacceptable';
        }
        $currentRequest = $this->retreatRequests()->where('retreat_season_id', $currentSeason->id)->first();
        if (!$currentSeason || !$currentRequest) {
            return 'unacceptable';
        }
        $status = $this->retreatRequests()->where('retreat_season_id', $currentSeason->id)->first()->status;
        return match ($status) {
            ProgressStatusEnum::PENDING->value => 'under-review',
            ProgressStatusEnum::APPROVED->value => 'acceptable',
            ProgressStatusEnum::REJECTED->value => 'unacceptable',
            ProgressStatusEnum::CANCELLED->value => 'unacceptable',
            default => 'under-review',
        };
    }
    public function hasPermissionTo($permission): bool
    {
        if ($this->is_admin()) {
            return true;
        }
        if (in_array($permission, ['root', 'admins.profile', 'admins.update-profile'])) {
            return true;
        }
        $permission = explode('.', $permission)[0];
        return $this->permissions->contains('name', $permission);
    }
    public function is_admin()
    {
        return $this->user_type == UserTypesEnum::ADMIN->value;
    }
    public function hasPermissionsTo($permissions)
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermissionTo($permission)) {
                return true;
            }
        }
        return false;
    }

    public function retreatRateSurveys()
    {
        return $this->hasMany(RetreatRateSurvey::class, 'retreat_user_id');
    }
    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = Hash::make($value);
    // }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')->singleFile();
    }
    public function getAvatarUrlAttribute()
    {
        if (!$this->media('avatar')->first()) {
            return default_avatar();
        }
        return $this->media('avatar')->first()->getUrl();
    }

    public function setAvatarAttribute($value)
    {
        $this->clearMediaCollection('avatar');

        if ($value) {
            $this->addMedia($value)->preservingOriginal()->toMediaCollection('avatar');
        }
    }
    public function clearAvatarAttribute()
    {
        $this->clearMediaCollection('avatar');
    }
    public function getActiveNowAttribute()
    {
        if (!$this->last_active_at) {
            return false;
        }
        return Carbon::parse($this->last_active_at)->gt(Carbon::now()->subMinutes(5));
    }
    public function getAgeAttribute()
    {

        if (!empty($this->birthday) && strtotime($this->birthday)) {
            try {

                return Carbon::parse($this->birthday)->age;
            } catch (\Exception $e) {

                return null;
            }
        }


        return null;
    }
    public function getIsNotifiableAttribute()
    {
        return $this->notification_enabled && $this->is_active && !empty($this->fcm_token);
    }
    public function getCurrentRetreatRequestAttribute()
    {
        $currentSeason = currentSeason();
        if (!$currentSeason) {
            return null;
        }
        return $this->retreatRequests()->where('retreat_season_id', $currentSeason->id)
            ->whereIn('status', [ProgressStatusEnum::PENDING->value, ProgressStatusEnum::APPROVED->value])
            ->first();
    }
    public function getHasSurveyAttribute()
    {
        try {
            $has_survey = false;
            $latestEndedSeason = latestEndedSeason();

            if (!$latestEndedSeason) {
                return $has_survey;
            }
            $currentSeason = currentSeason();
            if ($currentSeason) {
                return $has_survey;
            }

            $userSurveyExists = RetreatRate::where('user_id', $this->id)
                ->where('retreat_season_id', $latestEndedSeason->id)
                ->exists();
            if ($userSurveyExists) {
                return $has_survey;
            }

            $userRequestExists = RetreatRequest::where('user_id', $this->id)
                ->where('retreat_season_id', $latestEndedSeason->id)
                ->whereIn('status', [
                    ProgressStatusEnum::APPROVED->value,
                    ProgressStatusEnum::COMPLETED->value,
                ])
                ->exists();
            if ($userRequestExists) {
                $has_survey = true;
            }

            return $has_survey;
        } catch (\Exception $e) {

            Log::error('Error in getHasSurveyAttribute: ' . $e->getMessage());
            return false;
        }
    }

    public function scopeEmployees($query)
    {
        return $query->where('user_type', UserTypesEnum::EMPLOYEE->value);
    }
    public function scopeAdmins($query)
    {
        return $query->where('user_type', UserTypesEnum::ADMIN->value);
    }
    public function scopeUsers($query)
    {
        return $query->where('user_type', UserTypesEnum::USER->value)
            ->where(function ($query) {
                $query->where('otp', NULL)
                    ->orWhere('is_active', true);
            });
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
