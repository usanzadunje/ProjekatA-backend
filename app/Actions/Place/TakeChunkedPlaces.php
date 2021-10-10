<?php


namespace App\Actions\Place;

use App\Models\Cafe;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TakeChunkedPlaces
{

    protected string $filter;
    protected string $sortBy;
    protected bool $getAllColumns;
    protected int $start;
    protected int $numberOfCafes;

    public function __construct()
    {
        $this->filter = request('filter') ?? '';
        $this->sortBy = request('sortBy') ?: 'default';
        $this->getAllColumns = request('getAllColumns') === 'true';
        $this->start = request()->route('start') ?: 0;
        $this->numberOfCafes = request()->route('numberOfCafes') ?: 20;
    }

    public function handle(): Collection
    {
        $selectedColumns = $this->getAllColumns
            ? Cafe::select('id', 'name', 'city', 'address', 'latitude', 'longitude')->withCount([
                'tables',
                'tables as taken_tables_count' => function(Builder $query) {
                    $query->where('empty', false);
                },
            ])->with(['images' => function($query) {
                $query->select('id', 'path', 'is_main', 'is_logo', 'imagable_id')->where('is_main', true)->orWhere('is_logo', true);
            }])
            : Cafe::select('id', 'name', 'latitude', 'longitude')->withCount([
                'tables',
                'tables as taken_tables_count' => function(Builder $query) {
                    $query->where('empty', false);
                },
            ])->with(['images' => function($query) {
                $query->select('id', 'path', 'is_main', 'is_logo', 'imagable_id')->where('is_main', true)->orWhere('is_logo', true);
            }]);

        return $selectedColumns
            ->sortedCafes($this->sortBy)
            ->where('name', 'LIKE', '%' . $this->filter . '%')
            ->skip($this->start)
            ->take($this->numberOfCafes)
            ->get();
    }
}