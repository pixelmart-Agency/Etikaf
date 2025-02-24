<?php

namespace App\Http\Requests;

use App\Enums\RetreatRateQuestionTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\RetreatRateQuestion;
use App\Models\RetreatRateAnswer;
use App\Responses\ErrorResponse;

class RetreatRateSurveyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'retreat_rate_question_ids' => 'required|array',
            'retreat_rate_question_ids.*' => [
                'integer',
                function ($attribute, $value, $fail) {
                    $currentSurvey = currentSurvey();
                    $validQuestionIds = RetreatRateQuestion::where('retreat_survey_id', $currentSurvey->id)
                        ->pluck('id')
                        ->toArray();

                    if (!in_array($value, $validQuestionIds)) {
                        $fail(__('translation.invalid_question_id', ['question_id' => $value]));
                    }
                },
            ],
            'retreat_rate_answer_ids' => 'array',
            // 'text_answers' => 'array',
        ];

        $currentSurvey = currentSurvey();
        $questions = RetreatRateQuestion::where('retreat_survey_id', $currentSurvey->id)->get();
        $i = 0;
        foreach ($questions as $question) {
            if ($question->type == RetreatRateQuestionTypeEnum::CHOOSE) {
                $rules['retreat_rate_answer_ids'] = 'required|array';
                $rules['text_answers'] = 'nullable';
            }
            // else {
            //     $rules['text_answers'] = 'required|array';
            //     $rules['retreat_rate_answer_ids'] = 'nullable';
            // }

            // if ($question->answer_type == 'required') {
            //     if (!isset(request()->get('retreat_rate_answer_ids')[$i]) || request()->get('retreat_rate_answer_ids')[$i] == null) {
            //         // return response()->json([
            //         //     'success' => false,
            //         //     'message' => __('translation.answer_required', ['question' => $question->question]),
            //         // ], 400);
            //         $validator->errors()->add('retreat_rate_answer_ids.' . $i, __('translation.answer_required', ['question' => $question->question]));
            //     }
            // }

            $rules['retreat_rate_answer_ids.*'] = function ($attribute, $value, $fail) use ($question) {
                if (empty($value)) {
                    $fail(__('translation.answer_required', ['question' => $question->question]));
                }
                $validAnswers = RetreatRateAnswer::where('retreat_rate_question_id', $question->id)
                    ->pluck('id')
                    ->toArray();

                if (!in_array($value, $validAnswers) && $question->type == RetreatRateQuestionTypeEnum::CHOOSE) {
                    $fail(__('translation.invalid_answer_for_question :question', ['question' => $question->question]));
                }
            };
            $i++;
        }

        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $currentSurvey = currentSurvey();
            $questions = RetreatRateQuestion::where('retreat_survey_id', $currentSurvey->id)->get();

            foreach ($questions as $i => $question) {
                if ($question->answer_type == 'required') {
                    $answer = request()->get('retreat_rate_answer_ids')[$i] ?? null;
                    if (empty($answer)) {
                        // Add a custom error message if the required answer is not provided
                        $validator->errors()->add('retreat_rate_answer_ids.' . $i, __('translation.answer_required', ['question' => $question->question]));
                    }
                }
            }
        });
    }


    /**
     * Custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'retreat_rate_question_ids.*.integer' => 'رقم السؤال يجب أن يكون عددا',
            'retreat_rate_answer_ids.*.integer' => 'رقم الإجابة الاختيارية يجب أن يكون عددا',
            'retreat_rate_answer_ids.*.exists' => 'رقم الإجابة الاختيارية غير موجود',
            'retreat_rate_question_ids.*.exists' => 'رقم السؤال غير موجود',
            'text_answers.*.string' => 'الإجابة النصية يجب أن يكون نص',
            'retreat_rate_answer_ids.*.required_without' => 'رقم الإجابة الاختيارية مطلوبا',
            'text_answers.*.required_without' => 'الإجابة النصية مطلوبا',
            'retreat_rate_question_ids.*.required' => 'رقم السؤال مطلوبا',
            'retreat_rate_question_ids.*.array' => 'رقم السؤال يجب أن يكون مصفوفا',
        ];
    }
}
