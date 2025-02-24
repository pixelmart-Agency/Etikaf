<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RetreatMosqueRequest extends FormRequest
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
            'image' => 'nullable|mimes:jpeg,png,jpg,svg|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'name.ar.required' => 'يجب عليك إدخال اسم المسجد',
            'description.ar.required' => 'يجب عليك إدخال الوصف',
            'sort_order.required' => 'يجب عليك إدخال الترتيب',
            'image.required' => 'يجب عليك إدخال صورة',
        ];
    }
}
