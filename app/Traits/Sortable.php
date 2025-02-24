<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait Sortable
{
    protected static function bootSortable()
    {
        static::creating(function (Model $model) {
            if (isset($model->sort_order)) {
                $existingRecord = static::where('sort_order', $model->sort_order)->first();

                if ($existingRecord) {
                    static::where('sort_order', '>=', $model->sort_order)
                        ->increment('sort_order');
                }
            } else {
                $maxSortOrder = static::max('sort_order');
                $model->sort_order = $maxSortOrder ? $maxSortOrder + 1 : 1;
            }
        });

        static::updating(function (Model $model) {
            if ($model->isDirty('sort_order')) {
                $oldSortOrder = $model->getOriginal('sort_order');
                $newSortOrder = $model->sort_order;

                if ($oldSortOrder < $newSortOrder) {
                    static::whereBetween('sort_order', [$oldSortOrder + 1, $newSortOrder])
                        ->decrement('sort_order');
                }

                if ($oldSortOrder > $newSortOrder) {
                    static::whereBetween('sort_order', [$newSortOrder, $oldSortOrder - 1])
                        ->increment('sort_order');
                }
            }
        });

        static::deleting(function (Model $model) {
            $deletedSortOrder = $model->sort_order;

            static::where('sort_order', '>', $deletedSortOrder)
                ->decrement('sort_order');
        });
    }
}
