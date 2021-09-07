<?php

namespace App\Actions\Owner\Place;

use App\Models\User;
use Illuminate\Validation\UnauthorizedException;

class UpdatePlaceInfo
{
    public function handle(array $validatedData, User $providedOwner = null)
    {
        $owner = $providedOwner ?: auth()->user();

        $place = $owner->ownerCafes;

        if(!$place)
        {
            throw new UnauthorizedException();
        }

        $place
            ->update($validatedData);

    }
}