<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
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

    public function update(User $user, Product $product): bool
    {
        return $product->place_id === $user->isOwner();
    }

    public function destroy(User $user, Product $product): bool
    {
        return $product->place_id === $user->isOwner();
    }

    public function upload(User $user, Product $product): bool
    {
        return $product->place_id === $user->isOwner();
    }
}
