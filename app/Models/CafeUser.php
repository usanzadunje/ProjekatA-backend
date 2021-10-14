<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\CafeUser
 *
 * @property int $user_id
 * @property int $cafe_id
 * @property int|null $expires_in
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CafeUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CafeUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CafeUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|CafeUser whereCafeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CafeUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CafeUser whereExpiresIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CafeUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CafeUser whereUserId($value)
 * @mixin \Eloquent
 */
class CafeUser extends Pivot
{
    use HasFactory;

    protected $primaryKey = ['user_id', 'cafe_id'];

    protected $guarded = [];



}
