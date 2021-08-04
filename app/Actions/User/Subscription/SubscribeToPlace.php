<?php


namespace App\Actions\User\Subscription;


use App\Jobs\RemoveUserSubscriptionOnCafe;
use App\Models\CafeUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SubscribeToPlace
{
    protected int $cafeId;
    protected int|null $notificationTime;

    public function __construct()
    {
        $this->cafeId = (int)request()->route('cafeId');
        $this->notificationTime = (int)request()->route('notificationTime') ?? null;

        Validator::make(
            ['cafe_id' => $this->cafeId],
            [
                'cafe_id' => [
                    'required',
                    'numeric',
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

    public function handle()
    {
        auth()->user()
            ->cafes()
            ->attach($this->cafeId);

        if($this->notificationTime)
        {
            RemoveUserSubscriptionOnCafe::dispatch(auth()->id(), $this->cafeId)
                ->delay(now()->addMinutes($this->notificationTime));
        }
    }
}