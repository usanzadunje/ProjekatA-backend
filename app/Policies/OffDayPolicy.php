<?php

namespace App\Policies;

use App\Models\OffDay;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OffDayPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
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

    public function changeStatus(User $user, OffDay $offDay): bool
    {
        return $offDay->user->place === $user->isOwner();
    }
}
