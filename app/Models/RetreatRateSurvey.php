<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RetreatRateSurvey extends Model
{
    use SoftDeletes;
    use LogsActivityTrait;
    use HasFactory;
    protected $fillable = [
        'retreat_rate_question_id',
        'retreat_rate_answer_id',
        'retreat_request_id',
        'text_answer',
        'retreat_survey_id',
        'retreat_user_id',
    ];
    public function retreatSurvey()
    {
        return $this->belongsTo(RetreatSurvey::class);
    }
    public function retreatRateQuestion()
    {
        return $this->belongsTo(RetreatRateQuestion::class);
    }
    public function retreatRateAnswer()
    {
        return $this->belongsTo(RetreatRateAnswer::class);
    }
    public function retreatRequest()
    {
        return $this->belongsTo(RetreatRequest::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'retreat_user_id');
    }
}
