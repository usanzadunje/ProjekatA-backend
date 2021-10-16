<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\PlaceUser
 *
 * @property int $user_id
 * @property int $place_id
 * @property int|null $expires_in
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PlaceUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlaceUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlaceUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|PlaceUser wherePlaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlaceUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlaceUser whereExpiresIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlaceUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlaceUser whereUserId($value)
 * @mixin \Eloquent
 */
class PlaceUser extends Pivot
{
    use HasFactory;

    protected $primaryKey = ['user_id', 'place_id'];

    protected $guarded = [];



}
