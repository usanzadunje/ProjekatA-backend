<?php


namespace App\Actions\User\Subscription;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UnsubscribeFromPlace
{
    protected int $placeId;

    public function __construct()
    {
        $this->placeId = (int)request()->route('placeId');

        Validator::make(
            ['place_id' => $this->placeId],
            [
                'place_id' => [
                    'exists:place_user',
                ],
            ],
        )->validate();
    }

    public function handle(User $providedUser = null)
    {
        $user = $providedUser ?: auth()->user();
        $user
            ->places()
            ->detach($this->placeId);
    }
}