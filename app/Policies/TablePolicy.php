<?php

namespace App\Policies;

use App\Models\Table;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TablePolicy
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

    public function toggle(User $user, Table $table): bool
    {
        return $user->place === $table->place_id;
    }

    public function update(User $user, Table $table): bool
    {
        return $user->isOwner() === $table->place_id;
    }

    public function destroy(User $user, Table $table): bool
    {
        return $user->isOwner() === $table->place_id;
    }

}
