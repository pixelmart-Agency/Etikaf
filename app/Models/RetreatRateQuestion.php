<?php

namespace App\Models;

use App\Enums\RetreatRateAnswerTypeEnum;
use App\Enums\RetreatRateQuestionTypeEnum;
use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RetreatRateQuestion extends Model
{
    use HasFactory;
    use LogsActivityTrait;
    use SoftDeletes;
    protected $fillable = [
        'question',
        'type',
        'answer_type',
        'sort_order',
        'retreat_survey_id',
        'max_num_characters',
    ];
    protected static function booted()
    {
        parent::booted();
        static::creating(function ($model) {
            $model->type = RetreatRateQuestionTypeEnum::CHOOSE;
        });
    }
    public static function getQuestionType($question_type)
    {
        $question_type = strtolower($question_type);
        switch ($question_type) {
            case '1':
                return RetreatRateQuestionTypeEnum::TEXT;
            case '2':
                return RetreatRateQuestionTypeEnum::CHOOSE;
            default:
                return RetreatRateQuestionTypeEnum::TEXT;
        }
    }
    public static function getAnswerType($answer_type)
    {
        $answer_type = strtolower($answer_type);
        switch ($answer_type) {
            case '1':
                return RetreatRateAnswerTypeEnum::REQUIRED;
            case '2':
                return RetreatRateAnswerTypeEnum::OPTIONAL;
            default:
                return RetreatRateAnswerTypeEnum::REQUIRED;
        }
    }
    public function retreatSurvey()
    {
        return $this->belongsTo(RetreatSurvey::class);
    }
    public function retreatRateAnswers()
    {
        return $this->hasMany(RetreatRateAnswer::class);
    }
}
