<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\Image
 *
 * @property int $id
 * @property string $path
 * @property int $is_main
 * @property int $is_logo
 * @property string $imagable_type
 * @property int $imagable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $imagable
 * @method static \Illuminate\Database\Eloquent\Builder|Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereImagableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereImagableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereIsLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereIsMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Image extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function imagable(): MorphTo
    {
        return $this->morphTo();
    }
}
