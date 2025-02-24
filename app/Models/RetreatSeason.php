<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RetreatSeason extends Model
{
    use HasFactory;
    use LogsActivityTrait;
    use SoftDeletes;
    protected $fillable = [
        'start_date',
        'end_date',
        'status',
    ];

    public function retreatRequests()
    {
        return $this->hasMany(RetreatRequest::class);
    }
}
