<?php

namespace App\Models;

use App\Queries\FilterAndChunk;
use App\Queries\SortPlaces;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Place
 *
 * @property int $id
 * @property string $name
 * @property string|null $city
 * @property string|null $address
 * @property string|null $email
 * @property string|null $phone
 * @property string $latitude
 * @property string $longitude
 * @property string $mon_fri
 * @property string $saturday
 * @property string $sunday
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Collection|\App\Models\Category[] $categories
 * @property-read int|null $categories_count
 * @property-read Collection|\App\Models\Image[] $images
 * @property-read int|null $images_count
 * @property-read \App\Models\User $owner
 * @property-read Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read Collection|\App\Models\User[] $subscribedUsers
 * @property-read int|null $subscribed_users_count
 * @property-read Collection|\App\Models\Table[] $tables
 * @property-read int|null $tables_count
 * @method static \Database\Factories\PlaceFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Place filterAndChunk($filterByColumn, $filter, $offset, $limit)
 * @method static \Illuminate\Database\Eloquent\Builder|Place newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Place newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Place query()
 * @method static \Illuminate\Database\Eloquent\Builder|Place sortByAvailability()
 * @method static \Illuminate\Database\Eloquent\Builder|Place sortByDefault()
 * @method static \Illuminate\Database\Eloquent\Builder|Place sortByDistance()
 * @method static \Illuminate\Database\Eloquent\Builder|Place sortByFood()
 * @method static \Illuminate\Database\Eloquent\Builder|Place sortedPlaces($sortBy)
 * @method static \Illuminate\Database\Eloquent\Builder|Place whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Place whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Place whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Place whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Place whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Place whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Place whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Place whereMonFri($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Place whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Place wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Place whereSaturday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Place whereSunday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Place whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Place whereUserId($value)
 * @mixin \Eloquent
 */
class Place extends Model
{
    use HasFactory, SortPlaces, FilterAndChunk;

    protected $guarded = [];

    public function tables(): HasMany
    {
        return $this->hasMany(Table::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function allAvailableCategories(): Collection
    {
        $defaultCategories = Category::whereNull('place_id')->get();

        return $defaultCategories->merge($this->categories);
    }

    public function allProductCategories(): Collection
    {
        return Category::whereIn('id', function($query) {
            $query
                ->select('category_id')
                ->from('products')
                ->where('place_id', $this->id);
        })->get();
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function subscribedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->whereNotNull('fcm_token');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imagable');
    }

    public function getTableWithSerialNumber($serialNumber): HasMany
    {
        return $this->tables()->where('serial_number', $serialNumber)->firstOrFail();
    }

    public function freeTablesCount(): int
    {
        return $this->tables()->available(true)->count();
    }

    public function isFull(): bool
    {
        return $this->freeTablesCount() === 0;
    }

    public function takenMaxCapacityTableRatio(): string
    {
        // Returning how many tables are taken out of place capacity
        // in a form taken/capacity *20/40*

        return $this->taken_tables_count . '/' . $this->tables_count;
    }

    public function calculateDistance($lat, $lng): array
    {
        return DB::select(DB::raw('
            SELECT ST_Distance_Sphere(
                point(?, ?),
                point(?, ?)
            ) distance
        '), [$lng ?? 0, $lat ?? 0, $this->longitude, $this->latitude]);
    }
}
