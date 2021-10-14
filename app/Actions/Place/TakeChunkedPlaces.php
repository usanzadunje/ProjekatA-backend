<?php


namespace App\Actions\Place;

use App\Models\Cafe;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TakeChunkedPlaces
{
    public function handle($getAllColumns, $sortBy, $filter, $offset, $limit): Collection
    {
        $placeQuery = $getAllColumns
            ? Cafe::select('id', 'name', 'city', 'address', 'latitude', 'longitude')
                ->withCount([
                    'tables',
                    'tables as taken_tables_count' => function(Builder $query) {
                        $query->where('empty', false);
                    },
                ])
                ->with(['images' => function($query) {
                    $query
                        ->select('id', 'path', 'is_main', 'is_logo', 'imagable_id')
                        ->where('is_main', true)
                        ->orWhere('is_logo', true);
                }])
            : Cafe::select('id', 'name', 'latitude', 'longitude')
                ->withCount([
                    'tables',
                    'tables as taken_tables_count' => function(Builder $query) {
                        $query->where('empty', false);
                    },
                ])
                ->with(['images' => function($query) {
                    $query
                        ->select('id', 'path', 'is_main', 'is_logo', 'imagable_id')
                        ->where('is_main', true)
                        ->orWhere('is_logo', true);
                }]);

        return $placeQuery
            ->sortedCafes($sortBy)
            ->filterAndChunk('name', $filter, $offset, $limit)
            ->get();
    }
}