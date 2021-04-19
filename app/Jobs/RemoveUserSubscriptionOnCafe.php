<?php

namespace App\Jobs;

use App\Models\Cafe;
use App\Models\CafeUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RemoveUserSubscriptionOnCafe implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The user cafe subscription instance.
     *
     * @var \App\Models\CafeUser
     */
    protected $subscription;

    /**
     * Create a new job instance.
     * @param CafeUser
     * @return void
     */
    public function __construct(CafeUser $subscription)
    {
        $this->subscription = $subscription->withoutRelations();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Cafe::find($this->subscription->cafe_id)->subscribedUsers()->detach($this->subscription->user_id);
    }
}
