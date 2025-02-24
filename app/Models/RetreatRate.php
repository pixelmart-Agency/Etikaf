<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RetreatRate extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivityTrait;
    protected $fillable = [
        'user_id',
        'rate',
        'comment',
        'retreat_season_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function retreatRequest()
    {
        return $this->belongsTo(RetreatRequest::class);
    }
}
