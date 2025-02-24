<?php

namespace App\Http\Requests;

use App\Enums\AppUserTypesEnum;
use App\Enums\DocumentTypesEnum;
use App\Enums\UserTypesEnum;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $request = request();
        $userId = $this->route('user')
            ? $this->route('user')->id
            : ($this->route('employee')
                ? $this->route('employee')->id
                : ($this->route('admin')
                    ? $this->route('admin')->id
                    : null));
        if (is_null($userId) && Auth::user()) {
            $userId = Auth::user()->id;
        }
        $rules = [
            'name' => [
                'nullable:user_type,' . UserTypesEnum::ADMIN->value,
                'string',
                'max:255',
            ],
            'email' => [
                'nullable',
                'email',
                Rule::unique('users', 'email')->ignore($userId)->whereNull('deleted_at')->where(function ($query) {
                    $query->whereNull('otp')
                        ->where('is_active', false);
                }),
            ],
            'mobile' => [
                (!$userId) ? 'required' : 'nullable',  // Required if userId is not set, nullable if userId is present
                Rule::unique('users', 'mobile')->ignore($userId)->whereNull('deleted_at')->where(function ($query) {
                    $query->whereNull('otp')
                        ->where('is_active', false);
                }), // Ensure uniqueness and exclude soft-deleted user
                'regex:/^5\d{8}$/',  // Validate Saudi mobile numbers starting with 05 followed by 8 digits
            ],

            'password' => [
                (!$userId) ? 'required' : 'nullable',
                'string',
                'min:8',
                'confirmed',
                'password_strength',
            ],
            'user_type' => [
                'nullable',
                Rule::in(UserTypesEnum::cases()),
            ],

            'document_type' => [
                'required_if:user_type,' . UserTypesEnum::USER->value,
                'string',
                Rule::in(DocumentTypesEnum::cases()),
            ],

            'document_number' => [

                Rule::requiredIf(function () use ($request) {
                    return in_array($request->input('document_type'), ['passport', 'national_id']);
                }),

                'nullable',
                'string',
                'max:255',


                Rule::unique('users', 'document_number')->ignore($userId)->whereNull('deleted_at')->where(function ($query) {
                    $query->whereNull('otp')
                        ->where('is_active', false);
                }),


                function ($attribute, $value, $fail) use ($request) {
                    $documentType = $request->input('document_type');

                    if ($documentType === 'passport') {

                        if (!preg_match('/^[A-Za-z0-9]{8,9}$/', $value)) {
                            $fail(__('translation.document_number.passport'));
                        }
                    } elseif ($documentType === 'national_id') {

                        if (!preg_match('/^\d{10}$/', $value)) {
                            $fail(__('translation.document_number.national_id'));
                        }
                    }
                },
            ],

            'birthday' => [
                'nullable',
                'string',
            ],
            'visa_number' => [
                'nullable',
                'string',
                'max:255',
                'required_if:app_user_type,visitor',
                Rule::unique('users', 'visa_number')->ignore($userId)->whereNull('deleted_at')->where(function ($query) {
                    $query->whereNull('otp')
                        ->where('is_active', false);
                }),

                'regex:/^[A-Za-z0-9]{8,16}$/', // Fixed regex syntax
            ],
            'app_user_type' => [
                'nullable',
                Rule::in(AppUserTypesEnum::cases()),
            ],
            'country_id' => [
                'nullable',
                'integer',
                Rule::exists('countries', 'id'),
            ],
            'avatar' => [
                'nullable',
                'mimes:jpeg,jpg,png,gif,svg',
                'max:5096',
                'nullable',
            ],
            'remove_avatar' => [
                'nullable',
                'boolean',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ];

        if ($this->isMethod('post') && request()->has('user_type') && request()->user_type == UserTypesEnum::USER->value) {
            $rules['user_type'][] = 'required';
            $rules['document_type'][] = 'required';
            $rules['document_number'][] = 'required';
        }

        return $rules;
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (isset($validator->getData()['birthday'])) {
                $birthday = $validator->getData()['birthday'];
                $formats = ['d/m/Y', 'm/d/Y', 'Y-m-d'];

                foreach ($formats as $format) {
                    if (Carbon::hasFormat($birthday, $format)) {
                        $birthday = Carbon::createFromFormat($format, $birthday)->format('Y-m-d');
                        break;
                    }
                }

                $today = Carbon::today();

                if ($birthday && Carbon::parse($birthday)->diffInYears($today) < 18) {
                    $validator->errors()->add('birthday', __('translation.birthday_eighteen_years'));
                }
            }
        });
    }




    public function messages()
    {
        return [
            'document_number.required' => __('translation.document_number.required'),
            'document_number.string' => __('translation.document_number.string'),
            'password.required' => __('translation.password.required'),
            'password.string' => __('translation.password.string'),
            'password.min' => __('translation.password.min'),
            'password.regex' => __('translation.password.regex'),
            'password.confirmed' => __('translation.password_confirmed'),
            'user_type.required' => __('translation.user_type.required'),
            'user_type.string' => __('translation.user_type.string'),
            'country_id.required' => __('translation.country_id.required'),
            'country_id.integer' => __('translation.country_id.integer'),
            'country_id.exists' => __('translation.country_id.exists'),
            'email.unique' => __('translation.email.unique'),
            'mobile.unique' => __('translation.mobile.unique'),
            'document_number.unique' => __('translation.document_number.unique'),
            'visa_number.unique' => __('translation.visa_number.unique'),
            'visa_number.regex' => __('translation.visa_number.regex'),
            'name.string' => __('translation.name.string'),
            'document_type.required' => __('translation.document_type.required'),
            'document_type.string' => __('translation.document_type.string'),
            'document_type.in' => __('translation.document_type.in'),
            'mobile.regex' => __('translation.mobile.regex'),
            'avatar.max' => __('translation.avatar_max'),
        ];
    }
}
