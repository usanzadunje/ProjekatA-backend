<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\PlaceUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PlaceFavoritesController extends Controller
{
    public function index()
    {
        $favouritePlaceIds = auth()->user()
            ->favoritePlaces()
            ->pluck('id');

        return response()->success('User favorite places ids', [
            'favorite_places' => $favouritePlaceIds,
        ]);
    }

    public function store(Place $place): void
    {
        Validator::make(
            ['place_id' => $place->id],
            [
                'place_id' => [
                    Rule::unique('favorite_place_user')
                        ->where(function($query) use ($place) {
                            return $query->where('place_id', $place->id)
                                ->where('user_id', auth()->id());
                        }),
                ],
            ],
            [
                'favorite_place' => trans('validation.favorite'),
            ]
        )->validate();

        auth()->user()->favoritePlaces()->attach($place);
    }

    public function destroy(Place $place): void
    {
        auth()->user()->favoritePlaces()->detach($place);
    }
}
