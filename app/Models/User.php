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
    public function subscribedToCafes($sortBy = 'name')
    {
        switch($sortBy)
        {
            case 'food':
                return $this->cafes()->select('id', 'name')->sortByFood()->get();
            case 'availability':
                return $this->cafes()->select('id', 'name')->sortByAvailability()->get();
            case 'distance':
                return $this->cafes()->select('id', 'name')->sortByDistance()->get();
            default;
                return $this->cafes()->select('id', 'name')->sortByDefault()->get();
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

    /**
     * Specifies the user's FCM token
     *
     * @return string|array
     */
    public function routeNotificationForFcm()
    {
        return $this->fcm_token;
    }

    public function isStaff()
    {
        return $this->cafe_id;
    }
}
