<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RetreatRateAnswer extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivityTrait;
    protected $fillable = [
        'answer',
        'retreat_rate_question_id',
        'text_color',
        'background_color',
    ];
    public function retreatRateQuestion()
    {
        return $this->belongsTo(RetreatRateQuestion::class);
    }
}
