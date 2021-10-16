<?php

namespace App\Policies;

use App\Models\Table;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StaffPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function before(User $user)
    {
        //Giving myself full access by lettings user with ID 1 to be always authorized
        if($user->id === 1)
        {
            return true;
        }
    }

    public function update(User $user, User $staff): bool
    {
        return $user->isOwner() === $staff->place;
    }

    public function destroy(User $user, User $staff): bool
    {
        return $user->isOwner() === $staff->place;
    }
}
