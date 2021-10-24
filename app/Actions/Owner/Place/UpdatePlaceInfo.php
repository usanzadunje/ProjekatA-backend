<?php

namespace App\Actions\Owner\Place;

use App\Models\User;
use Illuminate\Validation\UnauthorizedException;

class UpdatePlaceInfo
{
    public function handle(array $validatedData, User $providedOwner = null)
    {
        $owner = $providedOwner ?: auth()->user();

        $place = $owner->ownerPlaces;

        if(!$place)
        {
            throw new UnauthorizedException();
        }

        // Working hours
        $validatedData['mon_fri'] = $validatedData['working_hours']['mon_fri'];
        $validatedData['saturday'] = $validatedData['working_hours']['saturday'];
        $validatedData['sunday'] = $validatedData['working_hours']['sunday'];

        unset($validatedData['working_hours']);

        $place
            ->update($validatedData);

    }
}