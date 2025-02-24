<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

trait LogsActivityTrait
{
    protected static function bootLogsActivityTrait()
    {
        static::created(function ($model) {
            activity()
                ->performedOn($model)
                ->causedBy(Auth::user())
                ->log(get_class($model) . ' Created');
        });
        static::saving(function ($model) {
            $model->updated_at = Carbon::now();
        });
        static::saved(function ($model) {
            if ($model->updated_at != $model->created_at) {
                activity()
                    ->performedOn($model)
                    ->causedBy(Auth::user())
                    ->log(get_class($model) . ' Updated');
            }
        });
        static::deleted(function ($model) {
            activity()
                ->performedOn($model)
                ->causedBy(Auth::user())
                ->log(get_class($model) . ' Deleted');
        });
    }
    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
