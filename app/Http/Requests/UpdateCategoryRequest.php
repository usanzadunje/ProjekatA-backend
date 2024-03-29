<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->route('category'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'icon' => ['string', 'max:50'],
        ];
    }

    public function messages()
    {
        return [
            'icon.string' => trans('validation.bad_icon'),
            'icon.max' => trans('validation.bad_icon'),
        ];
    }
}
