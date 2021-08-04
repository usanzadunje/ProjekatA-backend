<?php


namespace App\Actions\User\Subscription;

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
                    'required',
                    'numeric',
                    'exists:cafe_user',
                ],
            ],
        )->validate();
    }

    public function handle()
    {
        auth()->user()
            ->cafes()
            ->detach($this->cafeId);
    }
}