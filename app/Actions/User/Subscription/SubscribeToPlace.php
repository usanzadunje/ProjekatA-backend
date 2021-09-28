<?php


namespace App\Actions\User\Subscription;


use App\Jobs\RemoveUserSubscriptionOnCafe;
use App\Models\CafeUser;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SubscribeToPlace
{
    protected int $cafeId;
    protected int|null $notificationTime;

    public function __construct()
    {
        $this->cafeId = (int)request()->route('cafeId');
        $this->notificationTime = (int)request()->route('notificationTime') ?: null;

        Validator::make(
            ['cafe_id' => $this->cafeId],
            [
                'cafe_id' => [
                    Rule::unique(CafeUser::class)
                        ->where(function($query) {
                            return $query->where('cafe_id', $this->cafeId)
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

        $newlyCreatedSubscription = CafeUser::create([
            'user_id' => $user->id,
            'cafe_id' => $this->cafeId,
            'expires_in' => $this->notificationTime,
        ]);

        if($this->notificationTime)
        {
            RemoveUserSubscriptionOnCafe::dispatch($user->id, $this->cafeId)
                ->delay($newlyCreatedSubscription->created_at->addMinutes($this->notificationTime));
        }
    }
}