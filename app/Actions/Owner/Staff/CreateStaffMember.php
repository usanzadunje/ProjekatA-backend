<?php

namespace App\Actions\Owner\Staff;

use App\Models\User;

class CreateStaffMember
{
    public function handle(array $validatedData, User $providedOwner = null)
    {
        $owner = $providedOwner ?: auth()->user();

        $placeId = ['cafe' => $owner->isOwner()];

        User::create($validatedData + $placeId);
    }
}