<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param mixed $user
     * @param array $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'bday' => ['required', 'date'],
            'phone' => ['regex:/^[0-9]+$/', 'nullable'],
            'username' => ['string', 'max:255', 'nullable'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore(auth()->id()),
            ],
        ])->validateWithBag('updateProfileInformation');

        if($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail)
        {
            $this->updateVerifiedUser($user, $input);
        }
        else
        {
            $user->forceFill([
                'fname' => $input['fname'],
                'lname' => $input['lname'],
                'bday' => $input['bday'],
                'phone' => $input['phone'],
                'username' => $input['username'],
                'email' => $input['email'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param mixed $user
     * @param array $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'fname' => $input['fname'],
            'lname' => $input['lname'],
            'bday' => $input['bday'],
            'phone' => $input['phone'],
            'username' => $input['username'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
