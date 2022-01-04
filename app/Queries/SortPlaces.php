<?php


namespace App\Queries;


use Illuminate\Support\Facades\DB;

trait SortPlaces
{
    public function scopeSortedPlaces($query, $sortBy)
    {
        return match ($sortBy)
        {
            'food' => $query
                ->sortByFood(),
            'favorites' => $query
                ->sortByFavoritePlaces(),
            'availability' => $query
                ->sortByAvailability(),
            'distance' => $query
                ->sortByDistance(),
            'random' => $query
                ->sortByRandomChoice(),
            default => $query
                ->sortByName(),
        };
    }


    public function scopeSortByFood($query)
    {
        return $query->whereIn('id', function($query) {
            $query->select('place_id')
                ->from('products')
                ->where('category_id', function($query) {
                    $query->select('id')
                        ->from('categories')
                        ->where('name', 'food');
                });
        })->inRandomOrder();
    }

    public function scopeSortByAvailability($query)
    {
        return $query->whereIn('id', function($query) {
            $query->select('place_id')
                ->from('tables')
                ->where('empty', true);
        })->inRandomOrder();
    }

    public function scopeSortByFavoritePlaces($query)
    {
        return $query->whereIn('id', function($query) {
            $query->select('place_id')
                ->from('favorite_place_user')
                ->where('user_id', auth('sanctum')->id());
        });
    }

    public function scopeSortByDistance($query)
    {
        $lat = request('latitude') ?? 0;
        $lng = request('longitude') ?? 0;

        $sqlDistance = DB::raw('
            ST_Distance_Sphere(
                point(' . $lng . ', ' . $lat . '),
                point(places.longitude, places.latitude)
            )
        ');

        return $query
            ->selectRaw("{$sqlDistance} AS distance")
            ->orderBy('distance');
    }

    public function scopeSortByRandomChoice($query)
    {
        return $query->inRandomOrder();
    }

    public function scopeSortByName($query)
    {
        return $query->orderBy('name');
    }

}
