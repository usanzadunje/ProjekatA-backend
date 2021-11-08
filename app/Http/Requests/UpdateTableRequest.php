<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTableRequest extends FormRequest
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
            'smoking_allowed' => ['required', 'boolean'],
            'seats' => ['nullable', 'numeric', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'smoking_allowed.boolean' => trans('validation.bad_smoking_choice'),
        ];
    }
}
