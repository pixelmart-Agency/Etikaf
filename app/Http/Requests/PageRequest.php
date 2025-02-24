<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
            'slug' => 'required|regex:/^[a-zA-Z]+$/|max:255',
            'content' => ['array', 'required'],
            'content.block.title' => 'array',
            'content.block.title.*' => 'required',
            'content.block.body' => 'array',
            'content.block.body.*.*' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.ar.required' => __('translation.title_required'),
            'slug.required' => __('translation.slug_required'),
            'slug.regex' => __('translation.must_be_alphabet'),
            'content.block.title.*.required' => __('translation.content_block_title_required'),
            'content.block.body.*.*.required' => __('translation.content_block_body_required'),

        ];
    }
}
