<?php

namespace App\Models;

use App\Queries\FilterAndChunk;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $provider_id
 * @property string|null $fname
 * @property string|null $lname
 * @property string|null $bday
 * @property string|null $phone
 * @property string|null $username
 * @property string|null $avatar
 * @property string $email
 * @property string|null $password
 * @property string|null $fcm_token
 * @property int|null $place
 * @property int|null $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Collection|\App\Models\Place[] $places
 * @property-read int|null $places_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Place|null $ownerPlaces
 * @property-read Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereActive($value)
 * @method static Builder|User whereAvatar($value)
 * @method static Builder|User whereBday($value)
 * @method static Builder|User wherePlace($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereFcmToken($value)
 * @method static Builder|User whereFname($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereLname($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePhone($value)
 * @method static Builder|User whereProviderId($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUsername($value)
 * @mixin \Eloquent
 * @property-read Collection|\App\Models\Place[] $favoritePlaces
 * @property-read int|null $favorite_places_count
 * @method static Builder|User filterAndChunk($filterByColumn, $filter, $offset, $limit)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, FilterAndChunk;

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

    public function places(): BelongsToMany
    {
        return $this->belongsToMany(Place::class)->withTimestamps();
    }

    public function favoritePlaces(): BelongsToMany
    {
        return $this->belongsToMany(Place::class, 'favorite_place_user')->withTimestamps();
    }

    public function ownerPlaces(): HasOne
    {
        return $this->hasOne(Place::class);
    }

    public function staff($offset = null, $limit = null)
    {
        $place = $this->isOwner();

        return
            $place ?
                User::select('id', 'fname', 'lname', 'bday', 'phone', 'username', 'avatar', 'email', 'active')
                    ->wherePlace($place)
                    ->orderByDesc('active')
                    ->filterAndChunk(null, null, $offset, $limit)
                    ->get()
                :
                null;
    }

    public function getPlaceAttribute($value)
    {
        return $value ?: $this->isOwner();
    }

    public function isStaff(): ?int
    {
        return $this->place;
    }

    public function isOwner(): ?int
    {
        return $this->ownerPlaces()
            ->select('id')
            ->firstOr(fn() => null)
            ?->id;
    }

    //Places user has subscribed to
    public function subscribedToPlaces(string $sortBy = 'default'): Collection
    {
        return $this
            ->places()
            ->select('id', 'name', 'city', 'address', 'latitude', 'longitude')
            ->withCount([
                'tables',
                'tables as taken_tables_count' => function(Builder $query) {
                    $query->where('empty', false);
                },
            ])
            ->with(['images' => function($query) {
                $query
                    ->select('id', 'path', 'is_logo', 'imagable_id')
                    ->where('is_logo', true);
            }])
            ->withPivot('expires_in')
            ->sortedPlaces($sortBy)
            ->get();
    }
}
