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
        if($user->id === 1){
            return true;
        }
    }

    //public function toggle(User $user, Table $table): bool
    //{
    //    return $user->isStaff() === $table->cafe_id ||
    //        $user->isOwner() === $table->cafe_id;
    //}

}
