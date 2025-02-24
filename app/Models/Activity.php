<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\Models\Activity as ModelsActivity;

class Activity extends ModelsActivity
{

    public function scopeDisplayable(Builder $query)
    {
        return $query->whereHas('causer')->whereHas('subject')
            ->orderBy('created_at', 'desc')->whereIn('subject_type', [
                'App\Models\RetreatRequest',
                'App\Models\RetreatRequestServiceModel',
                'App\Models\RetreatSeason',
                'App\Models\Chat'
            ])->whereNotIn('description', [
                'App\Models\RetreatRequest Updated',
                'App\Models\RetreatRequest Created',
                'App\Models\RetreatSeason Created',
                'App\Models\RetreatSeason Updated',
                'App\Models\RetreatRequestServiceModel Updated',
                'App\Models\RetreatRequestServiceModel Created',
            ]);
    }
    public function scopeIsUnRead(Builder $query)
    {
        return $query->where(function ($query) {
            $query->whereRaw("JSON_EXTRACT(properties, '$.is_read') IS NULL") // إذا كان الحقل غير موجود
                ->orWhereRaw("JSON_EXTRACT(properties, '$.is_read') = false"); // إذا كان is_read = false
        });
    }
}
