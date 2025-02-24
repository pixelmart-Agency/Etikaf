<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rate' => 'required|integer|between:1,5',
            'comment' => 'required|string',
        ];
    }
    public function messages()
    {
        return [
            'rate.required' => __('translation.rate_required'),
            'rate.integer' => __('translation.rate_integer'),
            'rate.between' => __('translation.rating_between'),
            'comment.required' => __('translation.comment_required'),
            'comment.string' => __('translation.comment_string'),
        ];
    }
}
