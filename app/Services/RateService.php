<?php

namespace App\Services;

use App\Data\RetreatRateSurveyData;
use App\Enums\ProgressStatusEnum;
use App\Enums\RetreatRateQuestionTypeEnum;
use App\Enums\StatusEnum;
use App\Models\RetreatRate;
use App\Models\RetreatRateAnswer;
use App\Models\RetreatRateQuestion;
use App\Models\RetreatRateSurvey;
use App\Models\RetreatRequest;
use App\Models\RetreatSeason;
use App\Models\RetreatSurvey;
use App\Models\User;
use App\Notifications\RetreatRequestRatedNotification;
use Illuminate\Support\Facades\DB;
use Laravel\Prompts\Progress;

class RateService
{
    public function rate(int $rate, string $comment)
    {
        dd(latestEndedSeason());
        $rateObject = RetreatRate::create([
            'user_id' => user_id(),
            'rate' => $rate,
            'comment' => $comment,
            'retreat_season_id' => latestEndedSeason()?->id
        ]);
        return $rateObject;
    }
    public function getSurveys($perPage = 10)
    {
        $retreatSurveys = RetreatSurvey::active()->orderBy('id', 'desc')
            ->with(['retreatRateQuestions', 'retreatRateQuestions.retreatRateAnswers'])
            ->paginate($perPage);
        return $retreatSurveys;
    }
    public function getSurvey()
    {
        return RetreatSurvey::query()->active()->eagerLoad()->first();
    }
    public function createSurvey(RetreatRateSurveyData $retreatRateSurveyData, $retreatSurvey, $isTransaction = true)
    {
        if ($isTransaction) {
            return DB::transaction(function () use ($retreatRateSurveyData, $retreatSurvey) {
                return $this->createSurvey($retreatRateSurveyData, $retreatSurvey, false);
            });
        }
        $retreatRateSurveyData = $retreatRateSurveyData->toArray();
        $retreatRateQuestions = $retreatRateSurveyData['retreat_rate_question_ids'];
        for ($i = 0; $i < count($retreatRateQuestions); $i++) {
            $data = [
                'retreat_rate_question_id' => $retreatRateQuestions[$i],
                'retreat_rate_answer_id' => optional($retreatRateSurveyData['retreat_rate_answer_ids'])[$i],
                'text_answer' => optional($retreatRateSurveyData['text_answers'])[$i] ?? null,
                'retreat_survey_id' => $retreatSurvey->id,
                'retreat_user_id' => $retreatRateSurveyData['retreat_user_id'],
            ];
            RetreatRateSurvey::create($data);
        }
        return RetreatSurvey::query()->eagerLoadSurveys()->where('id', $retreatSurvey->id)->first();
    }
    public function getUsersWithSurveysGroupedBySurvey($surveyId)
    {
        // Get users who have participated in the survey
        $users = User::query()
            ->whereHas('retreatRateSurveys', function ($query) use ($surveyId) {
                $query->where('retreat_survey_id', $surveyId);
            })
            ->get();

        // Iterate over the users to add additional information
        $users->each(function ($user) use ($surveyId) {
            // Get the first retreatRateSurvey for this user
            $survey = $user->retreatRateSurveys()->where('retreat_survey_id', $surveyId)->first();

            // If the survey exists, we can add these fields
            if ($survey) {
                $user->survey_answer_date = $survey->created_at;
                $user->retreat_rate_questions_count = $user->retreatRateSurveys()->where('retreat_survey_id', $surveyId)->count();
            }
        });

        return $users;
    }

    public function getRateSurveysStats()
    {

        $ratesCats = [2, 1, 3, 4, 5];
        $rateStats = [];

        $totalRateSurveys = RetreatRate::query()
            ->where('retreat_season_id', latestEndedSeason()->id)
            ->count();
        foreach ($ratesCats as $rate) {
            $rateStat = new \stdClass();
            $rateStat->rate = $rate;

            // Use the preprocessed count, default to 0 if not found
            $rateStat->count = RetreatRate::query()->where('rate', $rate)->where('retreat_season_id', latestEndedSeason()->id)->count();
            $rateStat->percent = ($totalRateSurveys > 0) ? round(($rateStat->count / $totalRateSurveys) * 100) : 0;

            // Set other properties
            $rateStat->class = $this->getRateCategoryClass($rate);
            $rateStat->name = $this->getRateCategoryName($rate);
            $rateStat->status_id = $this->getRateCategoryStatusId($rate);

            // Add the rateStat object to the results array
            $rateStats[] = $rateStat;
        }

        return $rateStats;
    }

    public function getRateSurveysQuestionStats($surveyId)
    {
        // Fetch all rate questions for the given survey
        $surveyRateQuestions = RetreatRateQuestion::query()
            ->where('retreat_survey_id', $surveyId)
            ->where('type', RetreatRateQuestionTypeEnum::CHOOSE)
            ->get();


        $surveyStats = RetreatRateSurvey::query()
            ->whereIn('retreat_rate_question_id', $surveyRateQuestions->pluck('id'))
            ->where('retreat_survey_id', $surveyId)
            ->select('retreat_rate_question_id', \DB::raw('count(*) as count'))
            ->groupBy('retreat_rate_question_id')
            ->get()
            ->groupBy('retreat_rate_question_id');  // Group by question ID

        // Process each rate question
        foreach ($surveyRateQuestions as $surveyRateQuestion) {
            $surveyRateQuestion->people_count =  RetreatRateSurvey::query()
                ->where('retreat_rate_question_id', $surveyRateQuestion->id)
                ->where('retreat_survey_id', $surveyId)
                ->count();

            // Initialize rateStats array for this rate question
            $rateStats = [];
            // Process each rate category

            foreach ($surveyRateQuestion->retreatRateAnswers as $answer) {
                $surveyAnswerCount = RetreatRateSurvey::query()
                    ->where('retreat_rate_answer_id', $answer->id)
                    ->count();

                $answer->survey_answer_count = $surveyAnswerCount;
                $answer->survey_answer_percent = ($surveyAnswerCount > 0) ? round($surveyAnswerCount / $surveyRateQuestion->people_count * 100) : 0;
            }


            // Add the rateStats array to the rate question
        }

        // Return the survey rate questions with their rate statistics
        return $surveyRateQuestions;
    }


    public function getRateCategoryClass($rate)
    {
        switch ($rate) {
            case 2:
                return 'bg-green';
            case 4:
                return 'bg-brown';
            case 1:
                return 'bg-red-f5';
            case 3:
                return 'bg-light-gold';
            case 5:
                return 'bg-green-2d';
            default:
                return 'bg-green';
        }
    }
    public function getRateCategoryName($rate)
    {
        switch ($rate) {
            case 2:
                return __('translation.middle');
            case 1:
                return __('translation.weak');
            case 3:
                return __('translation.good');
            case 4:
                return __('translation.very_good');
            case 5:
                return __('translation.excellent');
            default:
                return __('translation.middle');
        }
    }
    public function getRateCategoryStatusId($rate)
    {
        switch ($rate) {
            case 2:
                return 'status-middle';
            case 1:
                return 'status-weak';
            case 3:
                return 'status-good';
            case 4:
                return 'status-very-good';
            case 5:
                return 'status-excellent';
            default:
                return 'status-middle';
        }
    }
    public function seasonUsersCount($surveyId)
    {
        $retreatSurvey = RetreatSurvey::query()->where('id', $surveyId)->first();
        $count = $retreatSurvey->getUsersWithApprovedOrCompletedStatus();
        return count($count);
    }
    public function seasonUsersWithSurveysCount($surveyId)
    {
        $seasonSurveys = RetreatSurvey::query()
            ->where('id', $surveyId)
            ->pluck('id');
        return User::query()->whereHas('retreatRateSurveys', function ($query) use ($seasonSurveys) {
            $query->whereIn('retreat_survey_id', $seasonSurveys);
        })->count();
    }
}
