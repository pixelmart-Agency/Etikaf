<?php

namespace App\Http\Requests;

use App\Services\RetreatSeasonService;
use Illuminate\Foundation\Http\FormRequest;

class SurveyRequest extends FormRequest
{
    protected $retreatSeasonService;
    public function __construct(RetreatSeasonService $retreatSeasonService)
    {
        $this->retreatSeasonService = $retreatSeasonService;
    }
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
        return [
            'title.ar' => 'required|string|max:255',
            'start_date' => 'required|string',
            'end_date' => 'required|string',
            'questions' => 'required|array',
            'questions.*.question' => 'required|string|max:255',
            'questions.*.answer_type' => 'required',
            'questions.*.answers' => [
                'required_if:type,2',
            ],

        ];
    }
    public function messages()
    {
        return [
            'title.ar.required' => __('translation.title_required'),
            'description.ar.required' => __('translation.description_required'),
            'start_date.required' => __('translation.start_date_required'),
            'end_date.required' => __('translation.end_date_required'),
            'questions.required' => __('translation.questions_required'),
            'questions.*.question.required' => __('translation.question_required'),
            'questions.*.type.required' => __('translation.question_type_required'),
            'questions.*.answer_type.required' => __('translation.question_answer_type_required'),
            'questions.*.max_num_characters.required' => __('translation.question_max_num_characters_required'),
            'questions.*.max_num_characters.min' => __('translation.question_max_num_characters_min'),
        ];
    }
}
