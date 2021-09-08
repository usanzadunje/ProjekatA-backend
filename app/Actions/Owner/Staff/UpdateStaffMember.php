<?php

namespace App\Actions\Owner\Staff;

use App\Models\User;

class UpdateStaffMember
{
    public function handle(User $staff, array $validatedData)
    {
        $user
            ->update($validatedData);
    }
}