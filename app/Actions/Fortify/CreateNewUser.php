<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param array $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'fname' => ['required', 'alpha', 'string', 'max:30'],
            'lname' => ['required', 'alpha', 'string', 'max:50'],
            'bday' => ['date', 'nullable'],
            'phone' => ['regex:/^[0-9]+$/', 'nullable'],
            'username' => ['string', 'max:50', 'required'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'fname' => $input['fname'],
            'lname' => $input['lname'],
            'bday' => $input['bday'],
            'phone' => $input['phone'],
            'username' => $input['username'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
