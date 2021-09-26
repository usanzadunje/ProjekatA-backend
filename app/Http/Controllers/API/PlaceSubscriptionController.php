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
    * Returning all cafes logged in users has subscribed to
    */
    public function index(): ResourceCollection
    {
        $sortBy = request('sortBy') ?? 'default';

        return CafeResource::collection(
            auth()->user()
                ->subscribedToCafes($sortBy)
        );
    }

    /*
     * Checking if users is subscribed to specific cafe
     *
     * @param int $cafeId
     */
    public function show(int $cafeId): JsonResponse
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
      * Subscribing to specific cafe
      *
      * @param int $cafeId
      * @param int $notificationTime
      */
    public function store(SubscribeToPlace $subscribeToPlace): void
    {
        $subscribeToPlace->handle();
    }

    /*
     * Unsubscribing specific cafe
     *
     * @param int $cafeId
     */
    public function destroy(UnsubscribeFromPlace $unsubscribeFromPlace): void
    {
        $unsubscribeFromPlace->handle();
    }
}
