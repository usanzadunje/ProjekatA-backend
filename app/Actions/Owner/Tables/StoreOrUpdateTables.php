<?php

namespace App\Actions\Owner\Tables;


use App\Models\Table;
use App\Models\User;

class StoreOrUpdateTables
{
    public function handle(array $validatedData, User $providedUser): array
    {
        $owner = $providedUser ?: auth()->user();
        $createdTables = [];

        foreach($validatedData as $table)
        {
            // Has to be leftToSave since there are bugs in frontend while there is only one left property
            // Therefore we manually create left for readability purposes
            $table['position']['left'] = $table['position']['leftToSave'];

            $existingTable = Table::where('id', $table['id'])
                ->firstOr(function() use ($table, $owner, &$createdTables) {
                    $createdTable = Table::create([
                        'cafe_id' => $owner->isOwner(),
                        'empty' => true,
                        'top' => $table['position']['top'],
                        'left' => $table['position']['left'],
                    ]);
                    array_push($createdTables, $createdTable);

                    return null;
                });

            if($existingTable)
            {
                abort_if($existingTable->cafe_id !== $owner->isOwner(), 403);

                $existingTable->update([
                    'top' => $table['position']['top'],
                    'left' => $table['position']['left'],
                ]);
            }
        }

        return $createdTables;
    }
}