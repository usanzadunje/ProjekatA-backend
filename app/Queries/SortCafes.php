<?php


namespace App\Queries;


use Illuminate\Support\Facades\DB;

trait SortCafes
{
    public function scopeSortedCafes($query, $sortBy)
    {
        return match ($sortBy)
        {
            'food' => $query
                ->sortByFood(),
            'availability' => $query
                ->sortByAvailability(),
            'distance' => $query
                ->sortByDistance(),
            default => $query
                ->sortByDefault(),
        };
    }


    public function scopeSortByFood($query)
    {
        return $query->whereIn('id', function($query) {
            $query->select('cafe_id')
                ->from('cafe_offering')
                ->whereIn('offering_id', function($query) {
                    $query->select('id')
                        ->from('offerings')
                        ->where('tag', 'food');
                });
        });
    }

    public function scopeSortByAvailability($query)
    {
        return $query->whereIn('id', function($query) {
            $query->select('cafe_id')
                ->from('tables')
                ->where('empty', true)
                ->distinct();
        })->inRandomOrder();
    }

    public function scopeSortByDistance($query)
    {
        $lat = request('latitude') ?? 0;
        $lng = request('longitude') ?? 0;

        $sqlDistance = DB::raw('
            ST_Distance_Sphere(
                point(' . $lng . ', ' . $lat . '),
                point(cafes.longitude, cafes.latitude)
            )
        ');

        return $query
            ->selectRaw("{$sqlDistance} AS distance")
            ->orderBy('distance');
    }

    public function scopeSortByDefault($query)
    {
        return $query->orderBy('name');
    }

}