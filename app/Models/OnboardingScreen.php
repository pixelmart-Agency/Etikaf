<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class OnboardingScreen extends Model implements HasMedia
{
    use InteractsWithMedia;
    use SoftDeletes;
    use LogsActivityTrait;
    protected $fillable = ['title', 'description'];
    protected $casts = [
        'title' => 'array',
        'description' => 'array',
    ];
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
    public function scopeFilter($query)
    {
        if (request()->has('keyword')) {
            $query->where('title', 'like', '%' . request()->keyword . '%');
        }
        $query->orderBy('id', 'desc');
        return $query;
    }
}
