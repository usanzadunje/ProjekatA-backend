<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\Avatar;
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
            'fname' => ['nullable', 'string', 'alpha', 'max:255'],
            'lname' => ['nullable', 'string', 'alpha', 'max:255'],
            'username' => [
                'nullable',
                'string',
                'alpha_num',
                'max:255',
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
            'phone' => ['nullable', 'numeric',],
            'avatar' => ['nullable', 'string', new Avatar('jpg|jpeg|png')],
            'old_password' => ['string', Rule::requiredIf(!empty($this->password))],
            'password' => [
                'string',
                new Password,
                'confirmed',
                Rule::requiredIf(!empty($this->old_password)),
            ],
        ];
    }

}

