<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RetreatMosqueLocationRequest extends FormRequest
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
            'name.ar' => 'required',
            'description.ar' => 'required',
            'sort_order' => ['required', 'integer'],
            'retreat_mosque_id' => 'required|integer',
            'location' => 'required',
            'image' => 'nullable|mimes:jpeg,png,jpg,svg|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'name.ar.required' => __('translation.name_required'),
            'description.ar.required' => __('translation.description_required'),
            'sort_order.required' => __('translation.sort_order_required'),
            'retreat_mosque_id.required' => __('translation.retreat_mosque_id_required'),
        ];
    }
}
