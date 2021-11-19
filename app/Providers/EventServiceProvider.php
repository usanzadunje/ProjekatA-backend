<?php

namespace App\Providers;

use App\Models\OffDay;
use App\Models\Schedule;
use App\Models\Table;
use App\Observers\OffDayObserver;
use App\Observers\ScheduleObserver;
use App\Observers\TableObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Table::observe(TableObserver::class);
        OffDay::observe(OffDayObserver::class);
        Schedule::observe(ScheduleObserver::class);
    }
}
