<?php

namespace App\Models;

use App\Enums\ProgressStatusEnum;
use App\Enums\UserTypesEnum;
use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class RetreatRequestServiceModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivityTrait;


    protected $table = 'retreat_request_service';
    protected $fillable = [
        'retreat_request_id',
        'retreat_service_id',
        'status',
        'employee_id'
    ];
    public function retreatRequest()
    {
        return $this->belongsTo(RetreatRequest::class);
    }
    public function retreatMosqueLocation()
    {
        return $this->belongsTo(RetreatRequest::class)->belongsTo(RetreatMosqueLocation::class, 'retreat_mosque_location_id');
    }


    public function getStatusClassAttribute()
    {
        return match ($this->status) {
            ProgressStatusEnum::PENDING->value => 'under-review',
            ProgressStatusEnum::APPROVED->value => 'acceptable',
            ProgressStatusEnum::COMPLETED->value => 'acceptable',
            ProgressStatusEnum::REJECTED->value => 'unacceptable',
            ProgressStatusEnum::CANCELLED->value => 'unacceptable',
            default => 'under-review',
        };
    }
    public function retreatService()
    {
        return $this->belongsTo(RetreatService::class);
    }
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }


    public function scopeFilter($query, $extra = [])
    {
        $request = request()->all();
        if (count($extra) > 0) {
            $request = array_merge($request, $extra);
        }

        if ($request['status']) {
            $query->where('status', $request['status']);
        }
        $currentSeason = currentSeason();
        if ($currentSeason) {
            $query->whereHas('retreatRequest', function ($query) use ($currentSeason) {
                $query->where('retreat_season_id', $currentSeason?->id);
            });
        } else {
            $query->whereHas('retreatRequest', function ($query) use ($currentSeason) {
                $query->where('retreat_season_id', null);
            });
        }
        return $query;
    }
    public function scopeEagerLoadData($query)
    {
        return $query->with([
            'retreatService',
            'retreatRequest.retreatMosqueLocation',
        ]);
    }
    public function scopeEmployeeRequests($query)
    {
        if (request()->has('status') && request()->status != ProgressStatusEnum::PENDING->value && Auth::user()->user_type == UserTypesEnum::EMPLOYEE->value) {
            return $query->where('employee_id', Auth::id());
        }
        return $query->orderBy('id', 'desc');
    }
}
