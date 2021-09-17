<?php


namespace App\Actions\Place\Table;


use App\Models\Cafe;
use App\Models\Table;
use App\Models\User;
use Illuminate\Validation\UnauthorizedException;

class ToggleTableAvailability
{
    public function handle($available, User $providedUser = null): array
    {
        $staff = $providedUser ?? auth()->user();

        $place = Cafe::select('id')
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