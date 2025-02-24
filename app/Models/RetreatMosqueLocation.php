<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use App\Traits\Sortable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class RetreatMosqueLocation extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivityTrait;
    use InteractsWithMedia;
    use Sortable;

    protected $fillable = [
        'name',
        'description',
        'sort_order',
        'retreat_mosque_id',
        'location',
        'avg_requests',
    ];
    protected $casts = [
        'sort_order' => 'integer',
        'name' => 'array',
        'description' => 'array',
    ];
    public function registerMediaCollections(Media $media = null): void
    {
        $this->addMediaCollection('image')
            ->singleFile();
    }
    public function getImagesAttribute()
    {
        return $this->getMedia('image')->getUrl();
    }
    public function getImageUrlAttribute()
    {
        return $this->getMedia('image')->count() ? $this->getMedia('image')->first()->getUrl() : '';
    }

    public function retreatMosque()
    {
        return $this->belongsTo(RetreatMosque::class);
    }
    public function retreatRequest()
    {
        $currentSeason = currentSeason();
        if ($currentSeason) {
            return $this->hasMany(RetreatRequest::class)->where('retreat_season_id', $currentSeason->id);
        }
        return $this->hasMany(RetreatRequest::class)->whereNull('retreat_season_id');
    }
    public function scopeFilter($query)
    {
        if (request()->has('retreat_mosque_id')) {
            $query->where('retreat_mosque_id', request()->get('retreat_mosque_id'));
        }
        if (request()->has('keyword')) {
            $keyword = '%' . request()->get('keyword') . '%';

            $query->where(function ($query) use ($keyword) {
                // Matching the decoded value of the `name` field
                $query->whereRaw("JSON_UNQUOTE(name) LIKE ?", [$keyword])
                    // Matching the 'ar' part of the JSON
                    ->orWhere('name->ar', 'like', $keyword);
            });
        }

        return $query->orderBy('sort_order');
    }
    public function determineRequestStatus()
    {
        $currentSeason = currentSeason();
        if (!$currentSeason || $currentSeason->start_date > Carbon::now()->toDateString()) {
            return 'season_not_started_yet';
        }
        $requestsCount = $currentSeason->retreatRequests()->count();
        if ($requestsCount < 500) {
            $locationRequests = $currentSeason->retreatRequests()->where('retreat_mosque_location_id', $this->id)->count();
            if ($locationRequests >= 0 && $locationRequests <= 200) {
                return 'low_requests';
            } elseif ($locationRequests >= 200 && $locationRequests <= 400) {
                return 'medium_requests';
            } else {
                return 'high_requests';
            }
        } else {
            if ($this->avg_requests >= 0 && $this->avg_requests <= 10) {
                return 'low_requests';
            } elseif ($this->avg_requests >= 11 && $this->avg_requests <= 50) {
                return 'medium_requests';
            } else {
                return 'high_requests';
            }
        }
    }

    public function getRequestStatusAttribute()
    {


        $status = $this->determineRequestStatus();
        $class = match ($status) {
            'low_requests' => 'acceptable',
            'medium_requests' => 'under-review',
            'high_requests' => 'unacceptable',
            'season_not_started_yet' => 'unacceptable',
        };

        return '<span class="' . $class . '"><span>' . __('translation.' . $status) . '</span></span>';
    }

    public function getRequestPlainStatusAttribute()
    {
        return __('translation.' . $this->determineRequestStatus());
    }

    public function getRequestStatusKeyAttribute()
    {
        return $this->determineRequestStatus();
    }
}
