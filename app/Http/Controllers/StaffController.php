<?php

namespace App\Http\Controllers;

use App\Events\CafeTableFreed;
use App\Events\TestEvent;
use App\Models\Cafe;
use App\Models\Table;
use Illuminate\Http\Request;
use Kutia\Larafirebase\Facades\Larafirebase;

class StaffController extends Controller
{
    public function sendNotification()
    {
        $deviceTokens = [
            '{TOKEN_1}',
        ];

        return Larafirebase::withTitle('Test Title')
            ->withBody('Test body')
            ->withImage('https://firebase.google.com/images/social.png')
            ->withClickAction('admin/notifications')
            ->withPriority('high')
            ->sendNotification($deviceTokens);

    }

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
            //Dispatch cafe is not full (table has been freed) event
            CafeTableFreed::dispatch($cafe);
        }
        //At the and regardless of income still toggle table.
        $table->toggleAvailability();

        return 200;
    }
}
