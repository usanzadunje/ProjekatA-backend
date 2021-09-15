<?php

namespace App\Actions\Owner\Staff;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateStaffMember
{
    public function handle(User $staff, array $validatedData)
    {
        if($validatedData['password'])
        {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $staff->update($validatedData);
    }
}