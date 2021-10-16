<?php


namespace App\Actions\User\Subscription;


use App\Jobs\RemoveUserSubscriptionOnPlace;
use App\Models\PlaceUser;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SubscribeToPlace
{
    protected int $placeId;
    protected int|null $notificationTime;

    public function __construct()
    {
        $this->placeId = (int)request()->route('placeId');
        $this->notificationTime = (int)request()->route('notificationTime') ?: null;

        Validator::make(
            ['place_id' => $this->placeId],
            [
                'place_id' => [
                    Rule::unique(PlaceUser::class)
                        ->where(function($query) {
                            return $query->where('place_id', $this->placeId)
                                ->where('user_id', auth()->id());
                        }),
                ],
            ],
            [
                'subscription' => trans('validation.subscription'),
            ]
        )->validate();
    }

    public function handle(User $providedUser = null)
    {
        $user = $providedUser ?: auth()->user();

        $newlyCreatedSubscription = PlaceUser::create([
            'user_id' => $user->id,
            'place_id' => $this->placeId,
            'expires_in' => $this->notificationTime,
        ]);

        if($this->notificationTime)
        {
            RemoveUserSubscriptionOnPlace::dispatch($user->id, $this->placeId)
                ->delay($newlyCreatedSubscription->created_at->addMinutes($this->notificationTime));
        }
    }
}