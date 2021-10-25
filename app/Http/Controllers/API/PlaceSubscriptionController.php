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

    public function subscriptionIds(): JsonResponse
    {
        $subscriptionsIds = auth()->user()
            ->places()
            ->select('id')
            ->pluck('id');

        return response()->success('User subscription ids', [
            'subscriptions' => $subscriptionsIds,
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
