<?php


namespace App\Actions\User\Subscription;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UnsubscribeFromPlace
{
    protected int $cafeId;

    public function __construct()
    {
        $this->cafeId = (int)request()->route('cafeId');

        Validator::make(
            ['cafe_id' => $this->cafeId],
            [
                'cafe_id' => [
                    'exists:cafe_user',
                ],
            ],
        )->validate();
    }

    public function handle(User $providedUser = null)
    {
        $user = $providedUser ?: auth()->user();
        $user
            ->cafes()
            ->detach($this->cafeId);
    }
}