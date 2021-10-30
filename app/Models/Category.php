<?php

namespace App\Models;

use App\Queries\FilterAndChunk;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property int|null $place_id
 * @property-read \App\Models\Place $place
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Database\Factories\CategoryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category wherePlaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory, FilterAndChunk;

    public $timestamps = false;

    protected $fillable = ['name', 'icon'];

    public function place(): ?BelongsTo
    {
        return $this->belongsTo(Place::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function chunkedProductsForPlace($placeId, $offset = 0, $limit = 7): Collection
    {
        return $this
            ->products()
            ->with(
                ['images' => function($query) {
                    $query
                        ->select('id', 'path', 'is_main', 'imagable_id');
                }])
            ->where('place_id', $placeId)
            ->filterAndChunk(null, null, $offset, $limit)
            ->orderByDesc('id')
            ->get();
    }
}
