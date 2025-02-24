<?php

namespace App\Models;

use App\Enums\SupportServiceTypeEnum;
use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupportService extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivityTrait;
    protected $fillable = [
        'name',
        'description',
        'sort_order',
    ];
    public function scopeFilter($query)
    {
        if (request()->has('keyword')) {
            $query->where('name', 'like', '%' . request()->keyword . '%');
        }
        $query->orderBy('sort_order');
        return $query;
    }
    public function scopeSupportServices($query)
    {
        $query->where('type', SupportServiceTypeEnum::SUPPORT->value);
        return $query;
    }
    public function scopeInRetreatServices($query)
    {
        $query->where('type', SupportServiceTypeEnum::IN_RETREAT->value);
        return $query;
    }
}
