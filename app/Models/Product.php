<?php

namespace App\Models;

use App\Queries\FilterAndChunk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int|null $price
 * @property int $cafe_id
 * @property int $category_id
 * @property-read \App\Models\Cafe $cafe
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Image[] $images
 * @property-read int|null $images_count
 * @method static \Database\Factories\ProductFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Product filterAndChunk($filterByColumn, $filter, $offset, $limit)
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCafeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasFactory, FilterAndChunk;

    public $timestamps = false;

    protected $guarded = [];

    public function cafe(): BelongsTo
    {
        return $this->belongsTo(Cafe::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imagable');
    }
}
