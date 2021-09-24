<?php

namespace App\Http\Controllers\API;

use App\Actions\User\Subscription\SubscribeToPlace;
use App\Actions\User\Subscription\UnsubscribeFromPlace;
use App\Http\Controllers\Controller;
use App\Http\Resources\CafeResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PlaceSubscriptionController extends Controller
{

    /*
     * Subscribing to specific cafe
     *
     * @param int $cafeId
     * @param int $notificationTime
     */
    public function subscribe(SubscribeToPlace $subscribeToPlace): JsonResponse
    {
        $subscribeToPlace->handle();

        return response()->success('User successfully subscribed!');
    }

    /*
     * Unsubscribing specific cafe
     *
     * @param int $cafeId
     */
    public function unsubscribe(UnsubscribeFromPlace $unsubscribeFromPlace): JsonResponse
    {
        $unsubscribeFromPlace->handle();

        return response()->success('User successfully unsubscribed!');
    }

    /*
     * Checking if users is subscribed to specific cafe
     *
     * @param int $cafeId
     */
    public function isUserSubscribed(int $cafeId): JsonResponse
    {
        $subscribed = auth()->user()
            ->cafes()
            ->where('cafe_id', $cafeId)
            ->first();

        return response()->success('User subscription status', [
            'subscribed' => !!$subscribed,
        ]);
    }

    /*
     * Returning all cafes logged in users has subscribed to
     */
    public function subscriptions() : ResourceCollection
    {
        $sortBy = request('sortBy') ?? 'default';

        return CafeResource::collection(
            auth()->user()
                ->subscribedToCafes($sortBy)
        );
    }
}
