<?php


namespace App\Traits;


trait Sortable
{

    public static function sortedCafes($getAllColumns, $filter, $sortBy)
    {
        $selectedColumns = $getAllColumns
            ? (new static)::select('id', 'name', 'city', 'address', 'email', 'phone')
            : (new static)::select('id', 'name');

            switch($sortBy)
            {
                case 'hrana':
                    return $selectedColumns
                        ->whereIn('id', function($query){
                            $query->select('cafe_id')
                                ->from('cafe_offering')
                                ->whereIn('offering_id', function($query){
                                    $query->select('id')
                                        ->from('offerings')
                                        ->where('tag', 'hrana');
                                });
                        })
                        ->where('name', 'LIKE', '%' . $filter . '%')
                        ;
                case 'free':
                    return $selectedColumns
                        ->where('name', 'LIKE', '%' . $filter . '%')
                        ->orderBy('id')
                        ;
                case 'closest':
                    return $selectedColumns
                        ->where('name', 'LIKE', '%' . $filter . '%')
                        ->orderBy('address')
                        ;
                default;
                    return $selectedColumns
                        ->where('name', 'LIKE', '%' . $filter . '%')
                        ->orderBy('name');
            }
    }

}