<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RetreatInstruction extends Model
{
    use HasFactory;
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
    public function scopeFilter($query)
    {
        if (request()->has('keyword')) {
            $query->where('name', 'like', '%' . request()->keyword . '%')
                ->orWhere('description', 'like', '%' . request()->keyword . '%');
        }
        $query->orderBy('sort_order');
        return $query;
    }
}
