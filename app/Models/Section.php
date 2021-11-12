<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Section
 *
 * @property int $id
 * @property string $name
 * @property int|null $place_id
 * @method static \Illuminate\Database\Eloquent\Builder|Section newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Section newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Section query()
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section wherePlaceId($value)
 * @mixin \Eloquent
 */
class Section extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public $timestamps = false;
}
