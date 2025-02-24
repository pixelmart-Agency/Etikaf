<?php

namespace App\Http\Requests;

use App\Enums\DocumentTypesEnum;
use App\Enums\UserTypesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
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

    public function rules()
    {
        return [
            'document_number' => [
                'required',
                'string',
            ],
            'document_type' => [
                'required_if:user_type,' . UserTypesEnum::USER->value,
                'string',
                Rule::in(DocumentTypesEnum::cases()),
            ],
            'user_type' => [
                'required',
                'string',
                Rule::in(UserTypesEnum::cases()),
            ],
            'password' => [
                'required',
                'string',
            ],
        ];
    }
}
