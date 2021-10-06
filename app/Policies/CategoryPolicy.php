<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
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

    public function update(User $user, Category $category): bool
    {
        return $category->cafe_id === $user->isOwner() && $category->cafe_id;
    }


    public function destroy(User $user, Category $category): bool
    {
        return $category->cafe_id === $user->isOwner() && $category->cafe_id;
    }
}
