<?php

namespace App\Models;

use App\Queries\SortCafes;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;

class Cafe extends Model
{
    use HasFactory, SortCafes;

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
        $defaultCategories = Category::whereNull('cafe_id')->get();

        return $defaultCategories->merge($this->categories);
    }

    public function allProductCategories(): Collection
    {
        return Category::with(
            ['products' => function($query) {
                $query->where('cafe_id', $this->id);
            }])
            ->whereIn('id', function($query) {
                $query
                    ->select('category_id')
                    ->distinct()
                    ->from('products')
                    ->where('cafe_id', $this->id);
            })->get();
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
        // Returning how many tables are taken out of cafe capacity
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
