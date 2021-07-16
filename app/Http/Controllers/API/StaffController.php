<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Table;
use App\Notifications\CafeTableFreed;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;

class StaffController extends Controller
{
    /**
     * Toggle table availability.
     * @param Table $table
     * @return JsonResponse
     */
    public function toggleAvailability(Table $table)
    {
        $cafe = $table->cafe;

        //Check if staff member is trying to change table within cafe he works in
        //abort_if(!Gate::allows('toggle-table', $cafe), 403, 'Unauthorized access.');


        if($cafe->isFull())
        {
            // Notify all subscribed users that table has been freed in cafe
        }
            $cafe->sendTableFreedNotificationToSubscribers();
        //At the and regardless of income still toggle table.
        $table->toggleAvailability();

        return new JsonResponse('Successfully changed cafe!');
    }
}
