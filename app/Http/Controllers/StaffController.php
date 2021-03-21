<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Models\Table;
use App\Models\User;
use App\Notifications\CafeTableFreed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class StaffController extends Controller
{
    /**
     * Toggle table availability.
     * @param Table $table
     * @return bool
     */
    public function toggleAvailability(Table $table)
    {
        $cafe = Cafe::findOrFail($table->cafe_id);

        if($cafe->isFull())
        {
            // Notify all subscribed users that table has been freed in cafe
            $users = $cafe->subscribedUsers;
            Notification::send($users, new CafeTableFreed($cafe));
            $cafe->subscribedUsers()->detach();
        }
        //At the and regardless of income still toggle table.
        $table->toggleAvailability();

        return true;
    }
}
