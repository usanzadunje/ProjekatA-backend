<?php

namespace App\Http\Controllers;

use App\Http\Resources\CafeResource;
use App\Jobs\RemoveUserSubscriptionOnCafe;
use App\Models\Cafe;
use App\Models\CafeUser;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Resource_;

class CafeController extends Controller
{
    /*
     * Display a listing of the resource.
     */
    public function index(): ResourceCollection
    {
        // Return everything except created and updated columns
        return CafeResource::collection(Cafe::all('id', 'name', 'city', 'address', 'email', 'phone'));
    }

    /*
     * Display a listing of the resource.
     *
     * @param int $start
     * @param int $numberOfCafes
     * @return ResourceCollection | string
     */
    public function chunkedIndex(int $start = 0, int $numberOfCafes = 20): ResourceCollection
    {
        $filter = request('filter') ?? '';
        $sortBy = request('sortBy') ?? 'name';
        $getAllColumns = request('getAllColumns') === 'true';

        // Returning false if there are no records to be returned
        // in order to disable infinite scroll on frontend
        if(count(Cafe::takeChunks($start, $numberOfCafes)) <= 0)
            return json_encode(false);

        // Passing only columns needed to Resource Cafe
        else return CafeResource::collection(Cafe::takeChunks($start, $numberOfCafes, $filter, $sortBy, $getAllColumns));
    }

    /*
     * Display the specified resource.
     *
     * @param int $cafeId
     */
    public function show(int $cafeId): CafeResource
    {
        // Passing only columns needed to show only one cafe
        return new CafeResource(
            Cafe::with('offerings')
                ->findOrFail(
                    $cafeId,
                    ['id', 'name', 'city', 'address', 'email', 'phone']
                )
        );
    }

    /*
     * Subscribing to specific cafe
     *
     * @param int $cafeId
     * @param int $notificationTime
     */
    public function subscribe(int $cafeId, int $notificationTime = null): l
    {
        $cafeUserUniqueMessage = [
            'cafeId' => 'User has already subscribed to cafe.',
        ];

        Validator::make(
            ['cafe_id' => $cafeId],
            [
                'cafe_id' => [
                    'required',
                    'numeric',
                    Rule::unique(CafeUser::class)
                        ->where(function($query) use ($cafeId) {
                            return $query->where('cafe_id', $cafeId)
                                ->where('user_id', auth()->id());
                        }),
                ],
            ],
            $cafeUserUniqueMessage
        )->validate();

        CafeUser::create([
            'user_id' => auth()->id(),
            'cafe_id' => $cafeId,
        ]);

        if($notificationTime)
        {
            RemoveUserSubscriptionOnCafe::dispatch(auth()->id(), $cafeId)
                ->delay(now()->addMinutes($notificationTime));
        }

        return json_encode([
            'success' => 'User successfully subscribed',
        ]);
    }

    /*
     * Unsubscribing specific cafe
     *
     * @param int $cafeId
     */
    public function unsubscribe(int $cafeId): bool
    {
        Validator::make(
            ['cafe_id' => $cafeId],
            [
                'cafe_id' => [
                    'required',
                    'numeric',
                    'exists:cafe_user',
                ],
            ],
        )->validate();

        if(auth()->user()->cafes()->detach($cafeId))
        {
            return json_encode([
                'success' => 'User successfully unsubscribing',
            ]);
        }
        else
        {
            return json_encode([
                'error' => 'Something went wrong with unsubscribing to cafe. Try again later.',
            ]);
        }
    }

    /*
     * Checking if user is subscribed to specific cafe
     *
     * @param int $cafeId
     */
    public function isUserSubscribed(int $cafeId): bool
    {
        $exists = CafeUser::where('user_id', auth()->id())->where('cafe_id', $cafeId)->first();

        return !!$exists;
    }

    /*
     * Returning all cafes logged in user has subscribed to
     */
    public function getAllCafesUserSubscribedTo(): ResourceCollection
    {
        $sortBy = request('sortBy') ?? 'name';

        return CafeResource::collection(auth()->user()->subscribedToCafes($sortBy)->makeHidden(['pivot']));
    }

}
