<?php

namespace App\Jobs;

use App\Models\CafeUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RemoveUserSubscriptionOnCafe implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The user cafe subscription instance.
     *
     */
    protected int $userId;
    protected int $cafeId;

    /**
     * Create a new job instance.
     * @param int $userId
     * @param int $cafeId
     * @return void
     */
    public function __construct(int $userId, int $cafeId)
    {
        $this->userId = $userId;
        $this->cafeId = $cafeId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        CafeUser::where(['user_id' => $this->userId, 'cafe_id' => $this->cafeId])->delete();
    }
}
