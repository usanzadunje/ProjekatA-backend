<?php


namespace App\Actions\Place\Table;


use App\Http\Resources\TableResource;
use App\Models\Place;
use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\UnauthorizedException;

class ToggleTableAvailability
{
    public function handle($available, User $providedUser = null): array
    {
        $staff = $providedUser ?? auth()->user();
        $placeQuery = null;

        $table = Table::where('place_id', $staff->place)
            ->available(!($available === 'true'))
            ->sharedLock()
            ->first();

        if($table)
        {
            $table->update([
                'empty' => !$table->empty,
            ]);

            $placeQuery = $table->place();
        }
        else
        {
            $table = null;
            $placeQuery = Place::where('id', $staff->place);
        }

        $place = $placeQuery
            ->withCount([
                'tables',
                'tables as taken_tables_count' => function(Builder $query) {
                    $query->where('empty', false);
                },
            ])
            ->firstOr(fn() => throw new UnauthorizedException);

        return [
            'availability_ratio' => $place->takenMaxCapacityTableRatio(),
            'changed_table_id' => $table?->id,
        ];
    }
}