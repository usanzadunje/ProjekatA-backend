<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const IS_ADMIN = 1;

    const IS_STAFF = 2;

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
        return $this->belongsToMany(Cafe::class)->withTimestamps();
    }

    public function ownerCafes(): HasOne
    {
        return $this->hasOne(Cafe::class);
    }

    public function staff()
    {
        $cafe = $this->isOwner();

        return
            $cafe ?
                User::select('id', 'fname', 'lname', 'bday', 'phone', 'username', 'avatar', 'email', 'active')
                    ->whereCafe($cafe)
                    ->orderByDesc('active')
                    ->get()
                :
                null;
    }

    public function getCafeAttribute($value)
    {
        return $value ?: $this->isOwner();
    }

    public function isStaff(): ?int
    {
        return $this->cafe;
    }

    public function isOwner(): ?int
    {
        return $this->ownerCafes()->select('id')->get()->id;
    }

    //Cafes user has subscribed to
    public function subscribedToCafes(string $sortBy = 'default'): Collection
    {
        return $this
            ->cafes()
            ->withCount([
                'tables',
                'tables as taken_tables_count' => function(Builder $query) {
                    $query->where('empty', false);
                },
            ])->with(['images' => function($query) {
                $query->select('id', 'path', 'cafe_id')->where('is_main', true);
            }])
            ->select('id', 'name', 'city', 'address', 'latitude', 'longitude')
            ->withPivot('expires_in')
            ->sortedCafes($sortBy)
            ->get();
    }
}
