<?php

namespace App\Policies;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchedulePolicy
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

    public function update(User $user, Schedule $schedule): bool
    {
        return $schedule->user->place === $user->isOwner();
    }

    public function destroy(User $user, Schedule $schedule): bool
    {
        return $schedule->user->place === $user->isOwner();
    }
}
