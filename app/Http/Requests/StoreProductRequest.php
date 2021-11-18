<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isOwner();
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
            'category_id' => [
                'required',
                'numeric',
                'integer',
                Rule::exists('categories', 'id')->where(function($query) {
                    return $query->whereIn('id', $this->user()->ownerPlaces->allAvailableCategories()->pluck('id'));
                }),
            ],
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
}
