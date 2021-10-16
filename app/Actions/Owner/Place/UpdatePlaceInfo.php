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
        $validatedData['mon_fri'] = "{$validatedData['mon_fri_start']}-{$validatedData['mon_fri_end']}";
        $validatedData['saturday'] = "{$validatedData['saturday_start']}-{$validatedData['saturday_end']}";
        $validatedData['sunday'] = "{$validatedData['sunday_start']}-{$validatedData['sunday_end']}";

        unset($validatedData['mon_fri_start']);
        unset($validatedData['mon_fri_end']);
        unset($validatedData['saturday_start']);
        unset($validatedData['saturday_end']);
        unset($validatedData['sunday_start']);
        unset($validatedData['sunday_end']);

        $place
            ->update($validatedData);

    }
}