<?php

namespace App\Jobs;

use App\Models\PlaceUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RemoveUserSubscriptionOnPlace implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The user place subscription instance.
     *
     */
    protected int $userId;
    protected int $placeId;

    /**
     * Create a new job instance.
     * @param int $userId
     * @param int $placeId
     * @return void
     */
    public function __construct(int $userId, int $placeId)
    {
        $this->userId = $userId;
        $this->placeId = $placeId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $userSubscription = PlaceUser::where(['user_id' => $this->userId, 'place_id' => $this->placeId]);

        if($userSubscription)
        {
            $userSubscription->delete();
        }
    }
}
