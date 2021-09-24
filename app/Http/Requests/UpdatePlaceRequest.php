<?php

namespace App\Http\Requests;

use App\Models\Cafe;
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
                Rule::unique(Cafe::class)->ignore(auth()->user()->isOwner()),
            ],
            'city' => [
                'nullable',
                'string',
            ],
            'address' => [
                'nullable',
                'string',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(Cafe::class)->ignore(auth()->user()->isOwner()),
            ],
            'phone' => [
                'nullable',
                'numeric',
            ],
        ];
    }
}
