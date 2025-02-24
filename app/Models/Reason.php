<?php

namespace App\Models;

use App\Enums\ReasonTypesEnum;
use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reason extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivityTrait;
    protected $fillable = [
        'title',
        'type',
    ];
    protected $casts = [
        'title' => 'json',
    ];
    public function scopeFilter($query)
    {
        $keyword = request('keyword');

        if ($keyword) {
            $query->where('title->en', 'like', "%$keyword%")
                ->orWhere('title->ar', 'like', "%$keyword%");
        }

        return $query->orderBy('id', 'desc');
    }
    public function scopeRejectReasons($query)
    {
        return $query->where('type', ReasonTypesEnum::REJECT_REQUEST);
    }
    public function scopeDeleteReasons($query)
    {
        return $query->where('type', ReasonTypesEnum::DELETE_ACCOUNT);
    }
}
