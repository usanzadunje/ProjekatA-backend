<?php

namespace App\Http\Controllers;

use App\Events\CafeTableFreed;
use App\Events\TestEvent;
use App\Models\Cafe;
use App\Models\Table;
use Illuminate\Http\Request;

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
            //Dispatch cafe is not full (table has been freed) event
            CafeTableFreed::dispatch($cafe);
        }
        //At the and regardless of income still toggle table.
        $table->toggleAvailability();

        return 200;
    }
}
