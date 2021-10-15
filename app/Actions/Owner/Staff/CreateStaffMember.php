<?php

namespace App\Actions\Owner\Staff;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateStaffMember
{
    public function handle(array $validatedData, User $providedOwner = null): User
    {
        $owner = $providedOwner ?: auth()->user();

        //Making staff belong to place that is owned by person who is creating him
        $additionalInfo = [
            'cafe' => $owner->isOwner(),
            'active' => false,
        ];

        $validatedData['password'] = Hash::make($validatedData['password']);

        return User::create($validatedData + $additionalInfo);
    }
}