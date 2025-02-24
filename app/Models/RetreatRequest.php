<?php

namespace App\Models;

use App\Enums\ProgressStatusEnum;
use App\Traits\LogsActivityTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RetreatRequest extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivityTrait;
    protected $fillable = [
        'retreat_mosque_id',
        'retreat_mosque_location_id',
        'location',
        'start_time',
        'end_time',
        'user_id',
        'name',
        'document_number',
        'birthday',
        'phone',
        'qr_code',
        'status',
        'retreat_season_id',
        'reason_id',
    ];
    protected static function booted()
    {
        parent::booted();
        static::created(function ($retreatRequest) {
            $mosqueLocation = $retreatRequest->retreatMosqueLocation;
            $allRequests = RetreatRequest::where('retreat_season_id', $retreatRequest->retreatSeason->id)->count();
            $locationRequests = RetreatRequest::where('retreat_mosque_location_id', $mosqueLocation->id)
                ->where('retreat_season_id', $retreatRequest->retreatSeason->id)
                ->count();
            $requestAvg = ($locationRequests / $allRequests) * 100;
            $mosqueLocation->update(['avg_requests' => floor($requestAvg)]);
        });
        static::deleting(function ($retreatRequest) {
            $retreatRequest->retreatServices()->delete();
            $retreatRequest->retreatRequestService()->delete();
        });
        static::restoring(function ($retreatRequest) {
            $retreatRequest->retreatServices()->restore();
            $retreatRequest->retreatRequestService()->restore();
        });
        static::forceDeleting(function ($retreatRequest) {
            $retreatRequest->retreatServices()->forceDelete();
            $retreatRequest->retreatRequestService()->forceDelete();
        });
        static::updated(function ($retreatRequest) {
            if (request()->has('status')) {
                $retreatRequest->retreatServices()->update([
                    'status' => request()->status,
                ]);
            }
        });
    }
    public function rejectReasonObject()
    {
        return $this->belongsTo(Reason::class, 'reason_id');
    }
    public function getStatusClassAttribute()
    {
        return match ($this->status) {
            ProgressStatusEnum::PENDING->value => 'under-review',
            ProgressStatusEnum::APPROVED->value => 'acceptable',
            ProgressStatusEnum::REJECTED->value => 'unacceptable',
            ProgressStatusEnum::CANCELLED->value => 'unacceptable',
            default => 'under-review',
        };
    }
    public function retreatMosque()
    {
        return $this->belongsTo(RetreatMosque::class);
    }
    public function retreatMosqueLocation()
    {
        return $this->belongsTo(RetreatMosqueLocation::class);
    }
    public function requestQrCode()
    {
        return $this->hasOne(RequestQrCode::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function retreatServices()
    {
        return $this->belongsToMany(RetreatService::class, 'retreat_request_service')
            ->withPivot('status')
            ->withTimestamps();  // Automatically manage created_at and updated_at
    }

    public function retreatRequestServices()
    {
        return $this->hasMany(RetreatRequestServiceModel::class);
    }
    public function retreatSeason()
    {
        return $this->belongsTo(RetreatSeason::class);
    }
    public function scopeEagerLoadData($query)
    {
        return $query->with([
            'retreatMosque',
            'retreatMosqueLocation',
            'retreatRequestServices',
        ]);
    }
    public function scopeFilter($query, $extra = [])
    {
        if (request()->has('status')) {
            $query->where('status', request()->status);
        }
        if (!empty($extra['status'])) {
            $query->where('status', $extra['status']);
        }
        if (request()->has('keyword')) {
            $query->orWhereHas('retreatMosque', function ($query) use ($extra) {
                $query->whereRaw("JSON_UNQUOTE(name) LIKE ?", ['%' . request()->get('keyword') . '%']);
            })->orWhereHas('retreatMosqueLocation', function ($query) use ($extra) {
                $query->whereRaw("JSON_UNQUOTE(name) LIKE ?", ['%' . request()->get('keyword') . '%']);
            })->orWhereHas('user', function ($query) use ($extra) {
                $query->where('name', 'like', '%' . request()->keyword . '%')
                    ->orWhere('document_number', 'like', '%' . request()->keyword . '%');
            })->orWhereHas('retreatRequestServices', function ($query) use ($extra) {
                $query->where('name', 'like', '%' . request()->keyword . '%');
            });
        }
        $retreatSeason = currentSeason();
        if ($retreatSeason)
            $query->where('retreat_season_id', $retreatSeason->id);
        else
            $query->where('retreat_season_id', 0);
        return $query->orderBy('created_at', 'desc');
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
    public function getStartTimeArabicAttribute()
    {
        return convertToHijri($this->created_at) . ' ' . arabicNum($this->created_at->format('H:i'));
    }
}
