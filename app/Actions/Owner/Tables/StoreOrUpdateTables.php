<?php

namespace App\Actions\Owner\Tables;


use App\Models\Table;
use App\Models\User;
use Illuminate\Validation\UnauthorizedException;

class StoreOrUpdateTables
{
    public function handle(array $validatedData, User $providedUser): void
    {
        $owner = $providedUser ?: auth()->user();

        foreach($validatedData as $table)
        {
            // Has to be leftToSave since there are bugs in frontend while there is only one left property
            // Therefore we manually create left for readability purposes
            $table['position']['left'] = $table['position']['leftToSave'];

            $existingTable = Table::where('id', $table['id'])
                ->firstOr(function() use ($table, $owner) {
                    Table::create([
                        'cafe_id' => $owner->isOwner(),
                        'empty' => false,
                        'top' => $table['position']['top'],
                        'left' => $table['position']['left'],
                    ]);

                    return null;
                });

            if($existingTable)
            {
                throw_if($existingTable->cafe_id !== $owner->isOwner(), UnauthorizedException::class);

                $existingTable->update([
                    'top' => $table['position']['top'],
                    'left' => $table['position']['left'],
                ]);
            }
        }
    }
}