<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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

    public function cafes()
    {
        return $this->belongsToMany(Cafe::class);
    }

    //Cafes user has subscribed to
    public function subscribedToCafes($sortBy = 'default')
    {
        switch($sortBy)
        {
            case 'food':
                return $this->cafes()
                    ->select('id', 'name', 'city', 'address', 'latitude', 'longitude')
                    ->sortByFood()
                    ->get();
            case 'availability':
                return $this->cafes()
                    ->select('id', 'name', 'city', 'address', 'latitude', 'longitude')
                    ->sortByAvailability()
                    ->get();
            case 'distance':
                return $this->cafes()
                    ->select('id', 'name', 'city', 'address', 'latitude', 'longitude')
                    ->sortByDistance()
                    ->get();
            default;
                return $this->cafes()
                    ->select('id', 'name', 'city', 'address', 'latitude', 'longitude')
                    ->sortByDefault()
                    ->get();
        }

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

    public function isStaff()
    {
        return $this->cafe_id;
    }
}
