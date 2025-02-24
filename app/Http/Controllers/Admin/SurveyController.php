<?php

namespace App\Http\Controllers\Admin;

use App\Actions\SendUserNotificationAction;
use App\Enums\ProgressStatusEnum;
use App\Enums\RetreatRateAnswerTypeEnum;
use App\Enums\RetreatRateQuestionTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\SurveyRequest;
use App\Http\Resources\Admin\SurveyResource;
use App\Http\Resources\SurveyResource as SurveyApiResource;
use App\Jobs\SendUserNotificationJob;
use App\Models\RetreatRateSurvey;
use App\Models\RetreatSeason;
use App\Models\RetreatSurvey as Survey;
use App\Models\User;
use App\Notifications\NotifyUsersForNewSurveyNotification;
use App\Services\RateService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Question\Question;
use App\Http\Resources\Export\SurveyResource as SurveyExportResource;

class SurveyController extends Controller
{
    protected $questionTypes;
    protected $answerTypes;
    protected $rateService;
    public function __construct(RateService $rateService)
    {
        $this->questionTypes = RetreatRateQuestionTypeEnum::cases();
        $this->answerTypes = RetreatRateAnswerTypeEnum::cases();
        $this->rateService = $rateService;
    }
    public function index()
    {
        $surveys = Survey::query()->filter()->get();
        $surveys = SurveyResource::collection($surveys);
        return view('admin.surveys.index', compact('surveys'));
    }

    public function create()
    {
        $survey = new Survey();
        return view('admin.surveys.edit')->with(['survey' => SurveyResource::make($survey), 'questionTypes' => $this->questionTypes, 'answerTypes' => $this->answerTypes]);
    }


    public function store(SurveyRequest $request, $inTransaction = true)
    {
        if ($inTransaction) {
            return DB::transaction(function () use ($request) {
                return $this->store($request, false);
            });
        }

        try {
            $start_date = Carbon::createFromFormat('m/d/Y', $request->start_date);
            $end_date = Carbon::createFromFormat('m/d/Y', $request->end_date);

            if (!$start_date || !$end_date) {
                return redirect()->back()->withErrors(['date_error' => __('translation.invalid_date_format')])->withInput();
            }
            if ($start_date->gt($end_date)) {
                return redirect()->back()->withErrors(['end_date' => __('translation.start_date_after_end_date')])->withInput();
            }
            if ($start_date->lt(Carbon::today())) {
                return redirect()->back()->withErrors(['start_date' => __('translation.start_date_before_today')])->withInput();
            }
            if ($end_date->lt(Carbon::today())) {
                return redirect()->back()->withErrors(['end_date' => __('translation.end_date_before_today')])->withInput();
            }
            Survey::where('is_active', true)->update(['is_active' => false]);
            $validateData = $request->validated();
            $validateData['is_active'] = true;
            $survey = Survey::create($validateData);
            foreach ($request->questions as $quest) {
                $question = $survey->retreatRateQuestions()->create($quest);
                $i = 1;
                foreach ($quest['answers'] as $answer) {
                    if (!is_null($answer)) {
                        $question->retreatRateAnswers()->create([
                            'answer' => $answer,
                            'text_color' => $quest['colors'][$i++]
                        ]);
                    }
                }
            }
            try {
                $sendUserNotificationAction = new SendUserNotificationAction();
                $sendUserNotificationAction->execute($survey);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
            return redirect()->route('surveys.index')->with(['title' => __('translation.Done'), 'success' => __('translation.create_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('surveys.index')->with(['title' => __('translation.Error'), 'error' => __('translation.something_went_wrong')]);
        }
    }


    public function edit(Survey $survey)
    {
        $survey = SurveyResource::make($survey);
        $old_data = old('questions');
        return view('admin.surveys.edit', compact('survey', 'old_data'));
    }

    public function update(SurveyRequest $request, Survey $survey, $inTransaction = true)
    {
        if ($inTransaction) {
            return DB::transaction(function () use ($request, $survey) {
                return $this->update($request, $survey, false);
            });
        }
        try {
            $survey->update($request->validated());
            return redirect()->route('surveys.index')->with(['title' => __('translation.Done'), 'success' => __('translation.update_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('surveys.index')->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }
    public function show(Survey $survey)
    {
        $users = $this->rateService->getUsersWithSurveysGroupedBySurvey($survey->id);
        $surveyStats = $this->rateService->getRateSurveysStats($survey->id);
        $surveyRateQuestions = $this->rateService->getRateSurveysQuestionStats($survey->id);
        $usersCount = $this->rateService->seasonUsersCount($survey->id);
        $surveysCount = $this->rateService->seasonUsersWithSurveysCount($survey->id);
        $surveysPercent = ($surveysCount > 0 && $usersCount > 0) ? round($surveysCount / $usersCount * 100) : 0;
        $survey = SurveyResource::make($survey);
        return view('admin.surveys.show', compact('survey', 'users', 'usersCount', 'surveysCount', 'surveysPercent', 'surveyStats', 'surveyRateQuestions'));
    }

    public function destroy(Survey $survey)
    {
        $survey->delete();
        return redirect()->route('surveys.index')->with(['title' => __('translation.Done'), 'success' => __('translation.delete_success')]);
    }
    public function switchStatus($surveyId)
    {
        try {
            $survey = Survey::where('id', $surveyId)->first();
            if (!$survey->is_active) {
                Survey::where('is_active', true)->update(['is_active' => false]);
                try {
                    $sendUserNotificationAction = new SendUserNotificationAction();
                    $sendUserNotificationAction->execute($survey);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                }
            }
            $survey->update(['is_active' => !$survey->is_active]);
            return response()->json(['status' => true, 'is_active' => $survey->is_active]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
    public function userSurveyQuestions($surveyId, $userId)
    {
        $questions = RetreatRateSurvey::where('retreat_survey_id', $surveyId)
            ->where('retreat_user_id', $userId)
            ->get();
        $survey = Survey::where('id', $surveyId)->first();
        return view('admin.surveys.questions_show', compact('survey', 'questions'));
    }
    public function export()
    {
        $data = Survey::query()->filter()->get();
        $data = SurveyExportResource::collection($data);
        return $data->toArray(request());
    }
}
