<?php

namespace App\Models;

use App\Enums\ProgressStatusEnum;
use App\Traits\LogsActivityTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RetreatSurvey extends Model
{
    use HasFactory;
    use LogsActivityTrait;
    use SoftDeletes;
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'is_active',
        'retreat_season_id',
    ];

    protected $casts = [
        'title' => 'array',
    ];
    protected static function booted()
    {
        parent::booted();
        static::creating(function ($model) {
            $latestEndedSeason = latestEndedSeason();
            $model->start_date = Carbon::parse($model->start_date)->format('Y-m-d');
            $model->end_date = Carbon::parse($model->end_date)->format('Y-m-d');
            $model->retreat_season_id = $latestEndedSeason?->id;
        });
        static::deleting(function ($model) {
            foreach ($model->retreatRateQuestions()->get() as $question) {
                $question->retreatRateAnswers()->delete();
            }
            $model->retreatRateQuestions()->delete();
        });
    }
    public function getUsersWithApprovedOrCompletedStatus()
    {
        $retreatSeason = latestEndedSeason();
        if (!$retreatSeason) {
            return [];
        }
        return $retreatSeason->retreatRequests()
            ->where(function ($query) {
                $query->where('status', ProgressStatusEnum::APPROVED->value)
                    ->orWhere('status', ProgressStatusEnum::COMPLETED->value);
            })
            ->pluck('user_id')
            ->unique()
            ->toArray();
    }

    public function retreatRateQuestions()
    {
        return $this->hasMany(RetreatRateQuestion::class);
    }
    public function retreatRateAnswers()
    {
        return $this->hasMany(RetreatRateAnswer::class);
    }
    public function retreatRateSurveys()
    {
        return $this->hasMany(RetreatRateSurvey::class);
    }
    public function scopeEagerLoad($query)
    {
        return $query->with(['retreatRateQuestions.retreatRateAnswers', 'retreatRateSurveys.retreatRateQuestion', 'retreatRateSurveys.retreatRateAnswer']);
    }
    public function scopeEagerLoadSurveys($query)
    {
        return $query->with(['retreatRateSurveys.retreatRateQuestion', 'retreatRateSurveys.retreatRateAnswer']);
    }
    public function getModelStatusAttribute()
    {
        $start_date = Carbon::parse($this->start_date);
        $end_date = Carbon::parse($this->end_date);
        $status = new \stdClass;
        if ($start_date <= Carbon::today() && $end_date >= Carbon::today()) {
            $status->td_class = 'acceptable';
            $status->text = __('translation.active');
        } elseif ($start_date > Carbon::today()) {
            $status->td_class = 'under-review';
            $status->text = __('translation.not_started');
        } elseif ($end_date < Carbon::today()) {
            $status->td_class = 'unacceptable';
            $status->text = __('translation.closed');
        }
        return $status;
    }
    public function getIsDeletableAttribute()
    {
        return $this->retreatRateSurveys()->count() == 0;
    }
    public function scopeFilter($query)
    {
        return $query->orderBy('id', 'desc');
    }


    public function scopeActive($query)
    {
        return $query->where('is_active', true)->whereDate('start_date', '<=', Carbon::today())->whereDate('end_date', '>=', Carbon::today());
    }
}
