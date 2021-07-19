<?php


namespace App\Queries;


use Illuminate\Support\Facades\DB;

trait SortCafes
{
    public function scopeSortedCafes($query, $sortBy, $filter = '')
    {
        switch($sortBy)
        {
            case 'food':
                return $query
                    ->sortByFood()
                    ->where('name', 'LIKE', '%' . $filter . '%');
            case 'availability':
                return $query
                    ->sortByAvailability()
                    ->where('name', 'LIKE', '%' . $filter . '%');
            case 'distance':
                return $query
                    ->sortByDistance()
                    ->where('name', 'LIKE', '%' . $filter . '%');
            default;
                return $query
                    ->sortByDefault()
                    ->where('name', 'LIKE', '%' . $filter . '%');
        }
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
        return $query->orderBy('id');
    }

    public function scopeSortByDistance($query)
    {
        $lng = request('lng') ?? 0;
        $lat = request('lat') ?? 0;

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