<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

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
        return $this->cafes()->select('id', 'name')->orderBy($sortBy)->get();
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return !!$value;
    }

    public function emailIsVerified()
    {
        return !!$this->email_verified_at;
    }

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
