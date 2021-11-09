<?php

namespace App\Policies;

use App\Models\Section;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SectionPolicy
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

    public function update(User $user, Section $section): bool
    {
        return $section->place_id === $user->isOwner() && $section->place_id;
    }

    public function destroy(User $user, Section $section): bool
    {
        return $section->place_id === $user->isOwner() && $section->place_id;
    }
}
