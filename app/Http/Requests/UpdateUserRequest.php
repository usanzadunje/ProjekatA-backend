<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'fname' => ['nullable', 'string', 'alpha'],
            'lname' => ['nullable', 'string', 'alpha'],
            'username' => [
                'nullable',
                'string',
                'alpha_num',
                Rule::unique(User::class)->ignore(auth()->id()),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore(auth()->id()),
            ],
            'bday' => ['nullable', 'date'],
            'phone' => ['nullable', 'numeric'],
            'old_password' => ['string', Rule::requiredIf(!!$this->password)],
            'password' => ['string', new Password, 'confirmed', Rule::requiredIf(!!$this->old_password)],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'email' => 'email address',
        ];
    }
}

