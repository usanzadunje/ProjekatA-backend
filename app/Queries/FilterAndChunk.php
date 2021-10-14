<?php


namespace App\Queries;

trait FilterAndChunk
{
    public function scopeFilterAndChunk($query, $filterByColumn, $filter, $offset, $limit)
    {
        return $query
            ->when($filterByColumn && ($filter || $filter === ''),
                fn($query) => $query->where($filterByColumn, 'LIKE', "%$filter%")
            )
            ->when(
                ($offset || $offset == 0) && $limit,
                fn($query) => $query->offset($offset)->limit($limit)
            );
    }
}