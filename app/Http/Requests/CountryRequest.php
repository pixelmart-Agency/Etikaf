<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
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
            'phone_code' => 'required|numeric',
        ];
    }
    public function messages()
    {
        return [
            'name.ar.required' => 'يجب عليك إدخال اسم الدولة',
            'phone_code.required' => 'يجب عليك إدخال رمز الدولة',
        ];
    }
}
