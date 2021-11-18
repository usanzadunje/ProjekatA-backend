<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreScheduleRequest extends FormRequest
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
            'start_date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'number_of_hours' => ['required', 'numeric', 'integer', 'max:24'],
            'user_id' => [
                'required',
                'numeric',
                'integer',
                Rule::exists('users', 'id')->where(function($query) {
                    return $query->where('place', $this->user()->isOwner());
                }),
            ],
        ];
    }

    public function messages()
    {
        return [
            'user_id.numeric' => trans('validation.bad_staff'),
            'user_id.integer' => trans('validation.bad_staff'),
            'user_id.exists' => trans('validation.non_existing_staff'),
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => trans('attributes.employee'),
        ];
    }
}
