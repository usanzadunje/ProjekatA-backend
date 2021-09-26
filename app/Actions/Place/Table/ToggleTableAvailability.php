<?php


namespace App\Actions\Place\Table;


use App\Models\Cafe;
use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\UnauthorizedException;

class ToggleTableAvailability
{
    public function handle($available, User $providedUser = null): array
    {
        $staff = $providedUser ?? auth()->user();

        $place = Cafe::select('id')
            ->withCount([
                'tables',
                'tables as taken_tables_count' => function(Builder $query) {
                    $query->where('empty', false);
                },
            ])
            ->where('id', $staff->cafe)
            ->firstOr(function() {
                throw new UnauthorizedException();
            });

        $table = Table::where('cafe_id', $place->id)
            ->available(!($available === 'true'))
            ->sharedLock()
            ->first();

        if($table)
        {
            $table->update([
                'empty' => !$table->empty,
            ]);
        }

        return [
            'availability_ratio' => $place->takenMaxCapacityTableRatio(),
        ];
    }
}