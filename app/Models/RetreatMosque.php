<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class RetreatMosque extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use LogsActivityTrait;
    use SoftDeletes;
    use Sortable;
    protected $fillable = [
        'name',
        'description',
        'sort_order',
    ];
    protected $casts = [
        'sort_order' => 'integer',
        'name' => 'array',
        'description' => 'array',
    ];
    public function retreatMosqueLocations()
    {
        return $this->hasMany(RetreatMosqueLocation::class);
    }
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

    public function scopeFilter($query)
    {
        return $query->orderBy('sort_order');
    }
}
