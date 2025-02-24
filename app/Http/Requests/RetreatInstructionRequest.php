<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RetreatInstructionRequest extends FormRequest
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
            'name.ar' => 'required|string|max:255',
            'description.ar' => 'required|string|max:255',
            'sort_order' => 'required|numeric',
        ];
    }
    public function messages()
    {
        return [
            'name.ar.required' => __('translation.title_required'),
            'description.ar.required' => __('translation.description_required'),
            'sort_order.required' => __('translation.sort_order_required'),

        ];
    }
}
