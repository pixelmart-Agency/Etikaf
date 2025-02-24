<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivityTrait;
    protected $fillable = [
        'name',
        'phone_code',
    ];
    protected $casts = [
        'name' => 'json',
    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function scopeFilter($query)
    {
        $keyword = request('keyword');

        if ($keyword) {
            $query->where('name->en', 'like', "%$keyword%")
                ->orWhere('name->ar', 'like', "%$keyword%");
        }

        return $query;
    }
}
