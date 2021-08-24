<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\Avatar;
use App\Rules\Password;
use App\Rules\Staff;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateStaffMemberRequest extends FormRequest
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
            'fname' => ['nullable', 'string', 'alpha'],
            'lname' => ['nullable', 'string', 'alpha'],
            'username' => [
                'required',
                'string',
                'alpha_num',
                Rule::unique(User::class),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => [
                'string',
                new Password,
                'confirmed',
            ],
            'cafe' => [
                'required',
                'numeric',
                'integer',
                new Staff(),
            ],
        ];
    }
}
