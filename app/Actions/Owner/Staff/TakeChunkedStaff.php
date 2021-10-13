<?php


namespace App\Actions\Owner\Staff;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class TakeChunkedStaff
{
    public function handle(int $placeId, $start, $staffNumber): Collection
    {
        User::select('id', 'fname', 'lname', 'bday', 'phone', 'username', 'avatar', 'email', 'active')
            ->whereCafe($placeId)
            ->skip($start)
            ->take($staffNumber)
            ->orderByDesc('active')
            ->get();
    }
}