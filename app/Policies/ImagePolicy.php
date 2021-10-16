<?php

namespace App\Policies;

use App\Models\Image;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImagePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function before(User $user)
    {
        //Giving myself full access by lettings user with ID 1 to be always authorized
        if($user->id === 1)
        {
            return true;
        }
    }

    public function manipulatePlaceImages(User $user, Image $image): bool
    {
        $imageParentId = $image->imagable_id;

        $isOwnersPlaceImage = $user->isOwner() === $imageParentId;
        $isOwnersProductImage = $user->ownerPlaces->products()->pluck('id')->contains($imageParentId);

        return $isOwnersPlaceImage || $isOwnersProductImage;
    }
}
