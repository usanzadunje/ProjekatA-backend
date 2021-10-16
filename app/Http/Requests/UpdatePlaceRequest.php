<?php

namespace App\Http\Requests;

use App\Models\Place;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePlaceRequest extends FormRequest
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
            'name' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique(Place::class)->ignore(auth()->user()->isOwner()),
            ],
            'city' => [
                'nullable',
                'string',
                'max:255',
            ],
            'address' => [
                'nullable',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(Place::class)->ignore(auth()->user()->isOwner()),
            ],
            'phone' => [
                'nullable',
                'numeric',
            ],
            'mon_fri_start' => [
                'required',
                'string',
                'max:10',
            ],
            'mon_fri_end' => [
                'required',
                'string',
                'max:10',
            ],
            'saturday_start' => [
                'required',
                'string',
                'max:10',
            ],
            'saturday_end' => [
                'required',
                'string',
                'max:10',
            ],
            'sunday_start' => [
                'required',
                'string',
                'max:10',
            ],
            'sunday_end' => [
                'required',
                'string',
                'max:10',
            ],
        ];
    }
}
