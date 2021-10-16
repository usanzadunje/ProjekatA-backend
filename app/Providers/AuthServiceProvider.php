<?php

namespace App\Providers;

use App\Models\Place;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\User' => 'App\Policies\StaffPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //ResetPassword::createUrlUsing(function($user, string $token) {
        //    return env('SPA_URL') . '/reset-password?token=' . $token;
        //});
        Gate::define('toggle-table', function(User $user, Place $place) {
            return $user->place_id === $place->id;
        });
    }
}
