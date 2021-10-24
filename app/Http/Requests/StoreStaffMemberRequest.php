<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\Avatar;
use App\Rules\Password;
use App\Rules\Staff;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStaffMemberRequest extends FormRequest
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
            'fname' => ['nullable', 'string', 'alpha', 'max:255'],
            'lname' => ['nullable', 'string', 'alpha', 'max:255'],
            'username' => [
                'required',
                'string',
                'alpha_num',
                'max:255',
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
                'required',
                'string',
                new Password,
            ],
        ];
    }
}
