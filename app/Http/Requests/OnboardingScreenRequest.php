<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OnboardingScreenRequest extends FormRequest
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
        return [
            'title.ar' => 'required|string|max:255',
            'description.ar' => 'required|string|max:255',
            'image' => [
                $this->isMethod('post') ? 'required' : 'nullable',
                'image',
                'mimes:jpeg,png,jpg,svg',
                'max:2048',
            ],
        ];
    }
    public function messages()
    {
        return [
            'title.ar.required' => __('translation.title_required'),
            'description.ar.required' => __('translation.description_required'),
            'image.required' => __('translation.image_required'),
        ];
    }
}
