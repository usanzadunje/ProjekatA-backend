<?php

namespace App\Actions\Owner\Staff;

use App\Models\User;

class CreateStaffMember
{
    public function handle($owner, array $validatedData)
    {
        $placeId = ['cafe' => $owner->isOwner()];

        User::create($validatedData + $placeId);
    }
}