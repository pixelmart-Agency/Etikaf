<?php

namespace App\Http\Controllers\Api;

use App\Data\RetreatRateSurveyData;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\RateRequest;
use App\Http\Requests\RetreatRateSurveyRequest;
use App\Http\Resources\RetreatRateSurveyResource;
use App\Http\Resources\SurveyResource;
use App\Models\RetreatRateSurvey;
use App\Models\RetreatRequest;
use App\Models\RetreatSurvey;
use App\Responses\ErrorResponse;
use App\Responses\SuccessResponse;
use App\Services\RateService;
use Illuminate\Support\Facades\Auth;

class RateController extends Controller
{
    protected $rateService;
    public function __construct(RateService $rateService)
    {
        $this->rateService = $rateService;
    }
    public function rate(RateRequest $request)
    {
        if (!user()->has_survey) {
            return ErrorResponse::send(__('translation.cant_rate'), 404);
        }
        $rate = $this->rateService->rate($request->rate, $request->comment);
        return SuccessResponse::send(1, __('translation.request_rated'), 200);
    }
    public function getSurveys()
    {
        $perPage = request()->get('per_page', 10);
        $retreatSurveys = $this->rateService->getSurveys($perPage);
        return SuccessResponse::send(SurveyResource::collection($retreatSurveys), __('translation.retreat_surveys'), 200, true);
    }
    public function getSurvey()
    {
        $retreatSurvey = $this->rateService->getSurvey();
        if (!$retreatSurvey) {
            return ErrorResponse::send(__('translation.retreat_survey_not_found'), 404);
        }
        return SuccessResponse::send(SurveyResource::make($retreatSurvey), __('translation.retreat_surveys'), 200);
    }
    public function createSurvey(RetreatRateSurveyRequest $request, RetreatSurvey $retreatSurvey)
    {
        if ($retreatSurvey->is_active == false) {
            return ErrorResponse::send(__('translation.retreat_survey_not_active'), 404);
        }
        if ($retreatSurvey->start_date > now() || $retreatSurvey->end_date < now()) {
            return ErrorResponse::send(__('translation.retreat_survey_not_active'), 404);
        }
        if ($retreatSurvey->retreat_season_id !== latestEndedSeason()->id) {
            return ErrorResponse::send(__('translation.retreat_survey_not_active'), 404);
        }
        $retreatRateSurveyData = RetreatRateSurveyData::fromArray($request->validated());
        $retreatRateSurveyData->retreat_user_id = Auth::user()->id;
        $questionIds = request()->retreat_rate_question_ids;
        foreach ($questionIds as $questionId) {
            $retreatRateSurvey = RetreatRateSurvey::where('retreat_survey_id', $retreatSurvey->id)
                ->where('retreat_request_id', $retreatRateSurveyData->retreat_request_id)
                ->where('retreat_user_id', $retreatRateSurveyData->retreat_user_id)
                ->where('retreat_rate_question_id', $questionId)
                ->exists();
            if ($retreatRateSurvey) {
                return ErrorResponse::send(__('translation.retreat_rate_survey_exists'), 404);
            }
        }
        $retreatSurvey = $this->rateService->createSurvey($retreatRateSurveyData, $retreatSurvey);
        return SuccessResponse::send(1, __('translation.request_rated'), 200);
    }
}
