<?php


namespace App\Traits;


trait Sortable
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
                    ->where('name', 'LIKE', '%' . $filter . '%')
                    ->sortByAvailability();
            case 'distance':
                return $query
                    ->where('name', 'LIKE', '%' . $filter . '%')
                    ->sortByDistance();
            default;
                return $query
                    ->where('name', 'LIKE', '%' . $filter . '%')
                    ->sortByDefault();
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
        return $query->orderBy('address');
    }

    public function scopeSortByDefault($query)
    {
        return $query->orderBy('name');
    }

}