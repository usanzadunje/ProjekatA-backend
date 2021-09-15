<?php

namespace App\Actions\Owner\Staff;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateStaffMember
{
    public function handle(array $validatedData, User $providedOwner = null)
    {
        $owner = $providedOwner ?: auth()->user();

        //Making staff belong cafe that is owned by person who is creating him
        $additionalInfo = [
            'cafe' => $owner->isOwner(),
            'active' => false,
        ];

        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData + $additionalInfo);
    }
}