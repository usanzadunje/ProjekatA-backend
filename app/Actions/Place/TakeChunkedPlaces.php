<?php


namespace App\Actions\Place;

use App\Models\Place;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TakeChunkedPlaces
{
    public function handle($getAllColumns, $sortBy, $filter, $offset, $limit): Collection
    {
        $placeQuery = $getAllColumns
            ? Place::select('id', 'name', 'city', 'address', 'latitude', 'longitude')
                ->withCount([
                    'tables',
                    'tables as taken_tables_count' => function(Builder $query) {
                        $query->where('empty', false);
                    },
                ])
                ->with(['images' => function($query) {
                    $query
                        ->select('id', 'path', 'is_main', 'is_logo', 'imagable_id')
                        ->where('is_logo', true);
                }])
            : Place::select('id', 'name', 'latitude', 'longitude')
                ->withCount([
                    'tables',
                    'tables as taken_tables_count' => function(Builder $query) {
                        $query->where('empty', false);
                    },
                ])
                ->with(['images' => function($query) {
                    $query
                        ->select('id', 'path', 'is_main', 'is_logo', 'imagable_id')
                        ->where('is_logo', true);
                }]);

        return $placeQuery
            ->sortedPlaces($sortBy)
            ->filterAndChunk('name', $filter, $offset, $limit)
            ->get();
    }
}