<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'numeric', 'integer', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:255'],
            'price' => ['nullable', 'numeric', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'category_id.numeric' => trans('validation.bad_category'),
            'category_id.integer' => trans('validation.bad_category'),
            'category_id.exists' => trans('validation.non_existing_category'),
        ];
    }

    public function attributes()
    {
        return [
            'category_id' => trans('attributes.category_id'),
        ];
    }
}
