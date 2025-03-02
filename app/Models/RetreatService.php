<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Enums\ProgressStatusEnum;

class RetreatService extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use LogsActivityTrait;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'description',
        'sort_order',
        'retreat_service_category_id',
    ];
    protected $casts = [
        'sort_order' => 'integer',
        'retreat_service_category_id' => 'integer',
        'name' => 'array',
        'description' => 'array',
    ];
    public function retreatServiceCategory()
    {
        return $this->belongsTo(RetreatServiceCategory::class);
    }
    public function retreatRequests()
    {
        return $this->belongsToMany(RetreatRequest::class, 'retreat_request_service');
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
    }
    public function getImageUrlAttribute()
    {
        if (!$this->media('image')->first()) {
            return null;
        }
        return $this->media('image')->first()->getUrl();
    }
    public function getIsRequestedAttribute()
    {
        $userId = user_id();
        $currentSeason = currentSeason();
        if (!$currentSeason) {
            return false;
        }
        if (!$userId) {
            return false;
        }
        return RetreatRequestServiceModel::where('retreat_season_id', $currentSeason->id)
            ->where('user_id', $userId)
            ->where('retreat_service_id', $this->id)
            ->exists();
    }

    public function scopeFilter($query, $params = [])
    {
        $request = request();
        $request->merge($params);
        if (request()->has('keyword')) {
            $query->where('name', 'like', '%' . request()->keyword . '%');
        }
        if (request()->has('retreat_service_category_id')) {
            $query->where('retreat_service_category_id', request()->retreat_service_category_id);
        }

        $query->orderBy('sort_order');
        return $query;
    }
    public function retreatRequest()
    {
        return $this->belongsToMany(RetreatRequest::class, 'retreat_request_service');
    }
}
