<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RetreatServiceCategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivityTrait;
    protected $fillable = [
        'name',
    ];
    protected $casts = [
        'name' => 'array',
    ];
    public function retreatServices()
    {
        return $this->hasMany(RetreatService::class);
    }
    public function scopeFilter($query)
    {
        if (request()->has('keyword')) {
            $query->where('name', 'like', '%' . request()->keyword . '%');
        }
        return $query->orderBy('id', 'DESC');
    }
}
