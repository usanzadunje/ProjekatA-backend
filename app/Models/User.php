<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cafes(): BelongsToMany
    {
        return $this->belongsToMany(Cafe::class);
    }

    //Cafes user has subscribed to
    public function subscribedToCafes($sortBy = 'default'): Collection
    {
        $selectedColumns = $this->cafes()
            ->select('id', 'name', 'city', 'address', 'latitude', 'longitude');
        
        return match ($sortBy)
        {
            'food' => $selectedColumns
                ->sortByFood()
                ->get(),
            'availability' => $selectedColumns
                ->sortByAvailability()
                ->get(),
            'distance' => $selectedColumns
                ->sortByDistance()
                ->get(),
            default => $selectedColumns
                ->sortByDefault()
                ->get(),
        };

    }

    //public function getEmailVerifiedAtAttribute($value)
    //{
    //    return !!$value;
    //}
    //
    //public function emailIsVerified()
    //{
    //    return !!$this->email_verified_at;
    //}

    public function isStaff(): bool
    {
        return !!$this->cafe_id;
    }
}
