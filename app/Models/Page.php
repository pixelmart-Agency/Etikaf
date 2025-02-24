<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivityTrait;
    protected $fillable = [
        'name',
        'slug',
        'content',
    ];
    protected $casts = [
        'name' => 'array',
        'content' => 'array',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            $page->slug = Str::slug($page->slug);
            $page->content = json_encode($page->content);
        });

        static::updating(function ($page) {
            $page->slug = Str::slug($page->slug);
            $page->content = json_encode($page->content);
        });
    }
    public function getContentAttribute($value)
    {
        return json_decode($value, true); // Decode the JSON content
    }
    public function getContentForApi($value)
    {
        $content = json_decode($value, true);

        $newContent = [];

        // If 'block' exists, map each block's title and body as an object
        if (isset($content['block']['title']) && isset($content['block']['body'])) {
            foreach ($content['block']['title'] as $key => $title) {
                $newContent[] = [
                    'title' => $title,
                    'body' => isset($content['block']['body'][$key]) ? $content['block']['body'][$key] : []
                ];
            }
        }

        return $newContent;
    }


    public function scopeFilter($query)
    {
        if (request()->has('keyword')) {
            $query->where('name', 'like', '%' . request()->keyword . '%')
                ->orWhere('description', 'like', '%' . request()->keyword . '%');
        }
        $query->orderBy('id', 'desc');
        return $query;
    }
}
