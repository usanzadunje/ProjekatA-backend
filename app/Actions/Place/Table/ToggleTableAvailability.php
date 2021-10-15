<?php


namespace App\Actions\Place\Table;


use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\UnauthorizedException;

class ToggleTableAvailability
{
    public function handle($available, User $providedUser = null): array
    {
        $staff = $providedUser ?? auth()->user();

        $table = Table::where('cafe_id', $staff->cafe)
            ->available(!($available === 'true'))
            ->sharedLock()
            ->firstOr(function() {
                throw new UnauthorizedException();
            });

        if($table)
        {
            $table->update([
                'empty' => !$table->empty,
            ]);
        }

        $place = $table
            ->cafe()
            ->withCount([
                'tables',
                'tables as taken_tables_count' => function(Builder $query) {
                    $query->where('empty', false);
                },
            ])
            ->first();

        return [
            'availability_ratio' => $place->takenMaxCapacityTableRatio(),
        ];
    }
}