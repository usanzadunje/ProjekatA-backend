<?php

namespace App\Actions\Owner\Tables;


use App\Models\Table;
use App\Models\User;

class StoreOrUpdateTables
{
    public function handle(array $validatedData, User $providedUser): void
    {
        $owner = $providedUser ?: auth()->user();

        foreach($validatedData as $table)
        {
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
                $existingTable->update([
                    'top' => $table['position']['top'],
                    'left' => $table['position']['left'],
                ]);
            }
        }
    }
}