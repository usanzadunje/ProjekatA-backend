<?php

namespace App\Http\Controllers\API;

use App\Actions\User\Subscription\SubscribeToPlace;
use App\Actions\User\Subscription\UnsubscribeFromPlace;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlaceResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PlaceSubscriptionController extends Controller
{
    /*
    * Returning all places logged in users has subscribed to
    */
    public function index(): ResourceCollection
    {
        $sortBy = request('sortBy') ?? 'default';

        return PlaceResource::collection(
            auth()->user()
                ->subscribedToPlaces($sortBy)
        );
    }

    public function show(int $placeId): JsonResponse
    {
        $subscribed = auth()->user()
            ->places()
            ->where('place_id', $placeId)
            ->first();

        return response()->success('User subscription status', [
            'subscribed' => !!$subscribed,
        ]);
    }

    public function store(SubscribeToPlace $subscribeToPlace): void
    {
        $subscribeToPlace->handle();
    }

    public function destroy(UnsubscribeFromPlace $unsubscribeFromPlace): void
    {
        $unsubscribeFromPlace->handle();
    }
}
